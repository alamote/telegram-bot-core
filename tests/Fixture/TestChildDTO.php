<?php

namespace BotTest\Fixture;

use Bot\DTO\DTO;

final class TestChildDTO extends DTO
{
    public ?string $value = null;

    /**
     * TestChildDTO constructor.
     */
    public function validate(): void
    {
        // no-op for test
    }
}
