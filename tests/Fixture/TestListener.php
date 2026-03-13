<?php

declare(strict_types=1);

namespace BotTest\Fixture;

use Bot\Attribute\Listener;

final class TestListener
{
    public static int $calls = 0;
    public static ?string $lastValue = null;

    /**
     * @param TestEvent $event
     */
    #[Listener(TestEvent::class)]
    public function onTestEvent(TestEvent $event): void
    {
        self::$calls++;
        self::$lastValue = $event->value;
    }

    /**
     * @return void
     */
    public static function reset(): void
    {
        self::$calls = 0;
        self::$lastValue = null;
    }
}
