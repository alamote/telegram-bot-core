<?php

declare(strict_types=1);

namespace BotTest\Fixture;

use Bot\Command\CommandInterface;
use Bot\DTO\Update\MessageUpdateDTO;

final class TestCommandWithoutAttribute implements CommandInterface
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
