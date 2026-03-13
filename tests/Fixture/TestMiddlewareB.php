<?php

declare(strict_types=1);

namespace BotTest\Fixture;

use Bot\DTO\Update\UpdateDTO;
use Bot\Middleware\MiddlewareInterface;

final class TestMiddlewareB implements MiddlewareInterface
{
    public static array $trace = [];

    /**
     * @inheritDoc
     */
    public function process(UpdateDTO $update, callable $next): void
    {
        self::$trace[] = 'B:before';
        $next($update);
        self::$trace[] = 'B:after';
    }

    /**
     * @return void
     */
    public static function reset(): void
    {
        self::$trace = [];
    }
}
