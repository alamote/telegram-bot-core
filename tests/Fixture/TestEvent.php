<?php

declare(strict_types=1);

namespace BotTest\Fixture;

use Bot\Event\EventInterface;

final class TestEvent implements EventInterface
{
    /**
     * @param string $value
     */
    public function __construct(public string $value = 'ok')
    {
    }
}
