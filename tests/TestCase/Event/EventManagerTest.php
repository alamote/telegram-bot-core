<?php

declare(strict_types=1);

namespace BotTest\TestCase\Event;

use Bot\Event\EventManager;
use BotTest\Fixture\TestEvent;
use BotTest\Fixture\TestListener;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class EventManagerTest extends TestCase
{
    /**
     * @return void
     * @throws \ReflectionException
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function testEmitCallsRegisteredListenerMethod(): void
    {
        TestListener::reset();

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with(TestListener::class)->willReturn(new TestListener());

        $manager = new EventManager($container);
        $manager->registerListener(TestListener::class);

        $manager->emit(new TestEvent('value-1'));

        $this->assertSame(1, TestListener::$calls);
        $this->assertSame('value-1', TestListener::$lastValue);
    }

    /**
     * @return void
     * @throws \ReflectionException
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function testRegisterListenerIsIdempotentForSameMethod(): void
    {
        TestListener::reset();

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with(TestListener::class)->willReturn(new TestListener());

        $manager = new EventManager($container);
        $manager->registerListener(TestListener::class);
        $manager->registerListener(TestListener::class);

        $manager->emit(new TestEvent('value-2'));

        $this->assertSame(1, TestListener::$calls);
        $this->assertSame('value-2', TestListener::$lastValue);
    }
}
