<?php

declare(strict_types=1);

namespace BotTest\TestCase\Bot;

use Bot\Action\ActionManagerInterface;
use Bot\Bot;
use Bot\Command\CommandManagerInterface;
use Bot\Event\EventManagerInterface;
use Bot\Middleware\MiddlewareManagerInterface;
use Bot\Provider\ServiceProviderInterface;
use Bot\Routing\RouterInterface;
use Bot\Update\UpdateFactoryInterface;
use DI\Container;
use PHPUnit\Framework\TestCase;

final class BotTest extends TestCase
{
    /**
     * @return void
     * @throws \Exception
     */
    public function testCreateAndGettersResolveCoreServices(): void
    {
        $bot = Bot::create('token');

        $this->assertInstanceOf(ActionManagerInterface::class, $bot->getActionManager());
        $this->assertInstanceOf(CommandManagerInterface::class, $bot->getCommandManager());
        $this->assertInstanceOf(RouterInterface::class, $bot->getRouter());
        $this->assertInstanceOf(EventManagerInterface::class, $bot->getEventManager());
        $this->assertInstanceOf(UpdateFactoryInterface::class, $bot->getUpdateFactory());
        $this->assertInstanceOf(MiddlewareManagerInterface::class, $bot->getMiddlewareManager());
    }

    /**
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Exception
     */
    public function testWithServiceProviderRegistersIntoContainer(): void
    {
        $bot = Bot::create('token');
        $provider = new class implements ServiceProviderInterface {
            public function register(Container $container): void
            {
                $container->set('custom.service', fn() => 'ok');
            }
        };

        $bot->withServiceProvider($provider);

        $this->assertSame('ok', $bot->getContainer()->get('custom.service'));
    }
}
