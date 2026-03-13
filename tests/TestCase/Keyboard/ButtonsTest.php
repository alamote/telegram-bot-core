<?php

declare(strict_types=1);

namespace BotTest\TestCase\Keyboard;

use Bot\Keyboard\Buttons\InlineButton;
use Bot\Keyboard\Buttons\ReplyButton;
use Bot\Keyboard\Buttons\UrlButton;
use PHPUnit\Framework\TestCase;

final class ButtonsTest extends TestCase
{
    /**
     * @return void
     */
    public function testInlineButtonSerializationAndValidation(): void
    {
        $btn = InlineButton::create()->setText('Click');
        $this->assertFalse($btn->isValid());

        $btn->setCallbackData('cb');
        $this->assertTrue($btn->isValid());

        $data = $btn->jsonSerialize();
        $this->assertSame('Click', $data['text']);
        $this->assertSame('cb', $data['callback_data']);
    }

    /**
     * @return void
     */
    public function testUrlButtonSerializationAndValidation(): void
    {
        $btn = UrlButton::create()->setText('Open');
        $this->assertFalse($btn->isValid());

        $btn->setUrl('https://example.com');
        $this->assertTrue($btn->isValid());

        $data = $btn->jsonSerialize();
        $this->assertSame('Open', $data['text']);
        $this->assertSame('https://example.com', $data['url']);
    }

    /**
     * @return void
     */
    public function testReplyButtonSerializationWithFlags(): void
    {
        $btn = ReplyButton::create()
                          ->setText('Share')
                          ->setRequestContact(true)
                          ->setRequestLocation(true);

        $data = $btn->jsonSerialize();
        $this->assertSame('Share', $data['text']);
        $this->assertTrue($data['request_contact']);
        $this->assertTrue($data['request_location']);
    }
}
