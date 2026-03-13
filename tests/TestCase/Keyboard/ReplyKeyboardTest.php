<?php

declare(strict_types=1);

namespace BotTest\TestCase\Keyboard;

use Bot\Keyboard\ReplyKeyboard;
use PHPUnit\Framework\TestCase;

final class ReplyKeyboardTest extends TestCase
{
    /**
     * @return void
     */
    public function testJsonSerializeContainsExpectedStructureWithDefaults(): void
    {
        $keyboard = ReplyKeyboard::create();

        $data = $keyboard->jsonSerialize();

        $this->assertArrayHasKey('keyboard', $data);
        $this->assertArrayHasKey('resize_keyboard', $data);
        $this->assertArrayHasKey('one_time_keyboard', $data);

        $this->assertTrue($data['resize_keyboard']);
        $this->assertFalse($data['one_time_keyboard']);
        $this->assertIsArray($data['keyboard']);
    }

    /**
     * @return void
     */
    public function testJsonSerializeReflectsConfiguredFlags(): void
    {
        $keyboard = ReplyKeyboard::create()
                                 ->setResize(false)
                                 ->setOneTime(true);

        $data = $keyboard->jsonSerialize();

        $this->assertFalse($data['resize_keyboard']);
        $this->assertTrue($data['one_time_keyboard']);
    }
}
