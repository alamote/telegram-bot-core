<?php

declare(strict_types=1);

namespace BotTest\Fixture;

use Bot\DTO\DTO;

final class TestParentDTO extends DTO
{
    public int $id = 0;
    public string $name = '';
    public TestChildDTO $child;

    /**
     * TestParentDTO constructor.
     */
    public function __construct()
    {
        $this->child = TestChildDTO::default();
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        // no-op for test
    }
}
