<?php

declare(strict_types=1);

namespace BotTest\TestCase\Provider;

use Bot\Action\ActionManagerInterface;
use Bot\Command\CommandManagerInterface;
use Bot\Config\ConfigServiceInterface;
use Bot\Event\EventManagerInterface;
use Bot\Http\ClientInterface;
use Bot\Http\Message\MessageFactoryInterface;
use Bot\Middleware\MiddlewareManagerInterface;
use Bot\Provider\CoreServiceProvider;
use Bot\Routing\RouterInterface;
use Bot\Update\UpdateFactoryInterface;
use Bot\Webhook\WebhookHandlerInterface;
use DI\Container;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class CoreServiceProviderTest extends TestCase
{
    /**
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function testRegisterBindsCoreInterfaces(): void
    {
        $c = new Container();
        $provider = new CoreServiceProvider('token', ['x' => 1]);
        $provider->register($c);

        $this->assertInstanceOf(LoggerInterface::class, $c->get(LoggerInterface::class));
        $this->assertInstanceOf(WebhookHandlerInterface::class, $c->get(WebhookHandlerInterface::class));
        $this->assertInstanceOf(ConfigServiceInterface::class, $c->get(ConfigServiceInterface::class));
        $this->assertInstanceOf(ClientInterface::class, $c->get(ClientInterface::class));
        $this->assertInstanceOf(MessageFactoryInterface::class, $c->get(MessageFactoryInterface::class));
        $this->assertInstanceOf(UpdateFactoryInterface::class, $c->get(UpdateFactoryInterface::class));
        $this->assertInstanceOf(CommandManagerInterface::class, $c->get(CommandManagerInterface::class));
        $this->assertInstanceOf(ActionManagerInterface::class, $c->get(ActionManagerInterface::class));
        $this->assertInstanceOf(MiddlewareManagerInterface::class, $c->get(MiddlewareManagerInterface::class));
        $this->assertInstanceOf(EventManagerInterface::class, $c->get(EventManagerInterface::class));
        $this->assertInstanceOf(RouterInterface::class, $c->get(RouterInterface::class));
    }
}
