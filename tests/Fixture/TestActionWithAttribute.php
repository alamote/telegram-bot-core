<?php

declare(strict_types=1);

namespace BotTest\Fixture;

use Bot\Action\ActionInterface;
use Bot\Attribute\Action;
use Bot\DTO\Update\CallbackQueryUpdateDTO;

#[Action('confirm', 'Confirm action')]
final class TestActionWithAttribute implements ActionInterface
{
    public bool $handled = false;

    /**
     * @inheritDoc
     */
    public function handle(CallbackQueryUpdateDTO $update, array $params = []): void
    {
        $this->handled = true;
    }
}
