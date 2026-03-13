<?php

declare(strict_types=1);

namespace BotTest\Fixture;

use Bot\Attribute\Command;
use Bot\Command\CommandInterface;
use Bot\DTO\Update\MessageUpdateDTO;

#[Command('start', 'Start command')]
final class TestCommandWithAttribute implements CommandInterface
{
    public bool $handled = false;

    /**
     * @inheritDoc
     */
    public function handle(MessageUpdateDTO $update): void
    {
        $this->handled = true;
    }
}
