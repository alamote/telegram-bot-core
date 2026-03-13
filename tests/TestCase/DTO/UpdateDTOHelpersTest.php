<?php

declare(strict_types=1);

namespace BotTest\TestCase\DTO;

use Bot\DTO\Update\CallbackQueryUpdateDTO;
use Bot\DTO\Update\MessageUpdateDTO;
use Bot\DTO\Update\UpdateDTO;
use PHPUnit\Framework\TestCase;

final class UpdateDTOHelpersTest extends TestCase
{
    /**
     * @return void
     */
    public function testMessageUpdateHelpers(): void
    {
        $dto = MessageUpdateDTO::fromArray([
            'message' => [
                'chat' => ['id' => 100],
                'from' => ['id' => 200, 'is_bot' => false, 'first_name' => 'X'],
            ],
        ], false);

        $this->assertSame(100, $dto->getChatId());
        $this->assertSame(200, $dto->getUserId());
        $this->assertFalse($dto->isEdit());
    }

    /**
     * @return void
     */
    public function testMessageUpdateIsEditWhenEditedMessageProvided(): void
    {
        $dto = MessageUpdateDTO::fromArray([
            'edited_message' => [
                'edit_date' => 1234567890,
                'chat' => ['id' => 101],
                'from' => ['id' => 201, 'is_bot' => false, 'first_name' => 'Y'],
            ],
        ], false);

        $this->assertTrue($dto->isEdit());
        $this->assertSame(101, $dto->getChatId());
        $this->assertSame(201, $dto->getUserId());
    }

    /**
     * @return void
     */
    public function testCallbackQueryUpdateHelpers(): void
    {
        $dto = CallbackQueryUpdateDTO::fromArray([
            'callback_query' => [
                'id' => 'cb1',
                'from' => ['id' => 500, 'is_bot' => false, 'first_name' => 'U'],
                'message' => [
                    'message_id' => 1,
                    'chat' => ['id' => 700],
                ],
            ],
        ], false);

        $this->assertSame(700, $dto->getChatId());
        $this->assertSame(500, $dto->getUserId());
    }

    /**
     * @return void
     */
    public function testBaseUpdateGetUserIdDefaultsToNull(): void
    {
        $dto = UpdateDTO::fromArray([], false);
        $this->assertNull($dto->getUserId());
    }
}
