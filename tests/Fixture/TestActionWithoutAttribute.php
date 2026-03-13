<?php

declare(strict_types=1);

namespace BotTest\Fixture;

use Bot\Action\ActionInterface;
use Bot\DTO\Update\CallbackQueryUpdateDTO;

final class TestActionWithoutAttribute implements ActionInterface
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
