<?php

declare(strict_types=1);

namespace BotTest\TestCase\Update;

use Bot\DTO\Update\CallbackQueryUpdateDTO;
use Bot\DTO\Update\MessageUpdateDTO;
use Bot\DTO\Update\UpdateDTO;
use Bot\Update\UpdateFactory;
use PHPUnit\Framework\TestCase;

final class UpdateFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateReturnsMessageUpdateDtoForMessage(): void
    {
        $dto = UpdateFactory::create(['message' => ['text' => 'hello']], false);
        $this->assertInstanceOf(MessageUpdateDTO::class, $dto);
    }

    /**
     * @return void
     */
    public function testCreateReturnsCallbackQueryUpdateDtoForCallbackQuery(): void
    {
        $dto = UpdateFactory::create(['callback_query' => ['data' => 'x']], false);
        $this->assertInstanceOf(CallbackQueryUpdateDTO::class, $dto);
    }

    /**
     * @return void
     */
    public function testCreateReturnsBaseUpdateDtoForOtherKnownUpdateTypes(): void
    {
        $dto = UpdateFactory::create([
            'update_id' => 123,
            'inline_query' => ['id' => '1', 'query' => 'abc', 'from' => []]
        ], false);
        $this->assertInstanceOf(UpdateDTO::class, $dto);
    }

    /**
     * @return void
     */
    public function testCreateThrowsForUnsupportedUpdate(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        UpdateFactory::create(['unknown' => 'x'], false);
    }
}
