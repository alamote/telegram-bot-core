<?php

declare(strict_types=1);

namespace BotTest\TestCase\Middleware;

use Bot\DTO\Update\UpdateDTO;
use Bot\Middleware\MiddlewareManager;
use BotTest\Fixture\TestMiddlewareA;
use BotTest\Fixture\TestMiddlewareB;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class MiddlewareManagerTest extends TestCase
{
    /**
     * @return void
     */
    public function testProcessCallsDestinationDirectlyWhenNoMiddleware(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $manager = new MiddlewareManager($container);

        $called = false;
        $manager->process($this->createMock(UpdateDTO::class), function () use (&$called) {
            $called = true;
        });

        $this->assertTrue($called);
    }

    /**
     * @return void
     */
    public function testProcessRespectsMiddlewareOrder(): void
    {
        TestMiddlewareA::reset();
        TestMiddlewareB::reset();

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->willReturnCallback(static function (string $class) {
            return new $class();
        });

        $manager = new MiddlewareManager($container);
        $manager->register(TestMiddlewareA::class);
        $manager->register(TestMiddlewareB::class);

        $trace = [];
        $manager->process($this->createMock(UpdateDTO::class), function () use (&$trace) {
            $trace[] = 'destination';
        });

        $all = array_merge(TestMiddlewareA::$trace, TestMiddlewareB::$trace, $trace);

        // Expected nesting:
        // A before -> B before -> destination -> B after -> A after
        $this->assertContains('A:before', $all);
        $this->assertContains('B:before', $all);
        $this->assertContains('destination', $all);
        $this->assertContains('B:after', $all);
        $this->assertContains('A:after', $all);
    }
}
