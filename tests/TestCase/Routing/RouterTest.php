<?php

declare(strict_types=1);

namespace BotTest\TestCase\Routing;

use Bot\Action\ActionManagerInterface;
use Bot\Command\CommandManagerInterface;
use Bot\DTO\Update\CallbackQueryUpdateDTO;
use Bot\DTO\Update\MessageUpdateDTO;
use Bot\DTO\Update\UpdateDTO;
use Bot\Event\EventManagerInterface;
use Bot\Event\Events\UnhandledEvent;
use Bot\Routing\Router;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class RouterTest extends TestCase
{
    /**
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function testRouteDelegatesMessageUpdateToCommandManager(): void
    {
        [$commandManager, $actionManager, $eventManager, $router] = $this->createRouterAndMocks();

        $update = $this->createMock(MessageUpdateDTO::class);

        $commandManager
            ->expects($this->once())
            ->method('handle')
            ->with($update);

        $actionManager->expects($this->never())->method('handle');
        $eventManager->expects($this->never())->method('emit');

        $router->route($update);
    }

    /**
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function testRouteDelegatesCallbackQueryUpdateToActionManager(): void
    {
        [$commandManager, $actionManager, $eventManager, $router] = $this->createRouterAndMocks();

        $update = $this->createMock(CallbackQueryUpdateDTO::class);

        $actionManager
            ->expects($this->once())
            ->method('handle')
            ->with($update);

        $commandManager->expects($this->never())->method('handle');
        $eventManager->expects($this->never())->method('emit');

        $router->route($update);
    }

    /**
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function testRouteEmitsUnhandledEventForUnknownUpdate(): void
    {
        [$commandManager, $actionManager, $eventManager, $router] = $this->createRouterAndMocks();

        $update = $this->createMock(UpdateDTO::class);

        $eventManager
            ->expects($this->once())
            ->method('emit')
            ->with($this->callback(function ($event) use ($update): bool {
                if (!$event instanceof UnhandledEvent) {
                    return false;
                }

                return $event->getUpdate() === $update;
            }));

        $commandManager->expects($this->never())->method('handle');
        $actionManager->expects($this->never())->method('handle');

        $router->route($update);
    }

    /**
     * @return array{CommandManagerInterface, ActionManagerInterface, EventManagerInterface, Router}
     */
    private function createRouterAndMocks(): array
    {
        $commandManager = $this->createMock(CommandManagerInterface::class);
        $actionManager = $this->createMock(ActionManagerInterface::class);
        $eventManager = $this->createMock(EventManagerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $router = new Router($commandManager, $actionManager, $eventManager, $logger);

        return [$commandManager, $actionManager, $eventManager, $router];
    }
}
