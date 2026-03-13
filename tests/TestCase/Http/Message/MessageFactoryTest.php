<?php

declare(strict_types=1);

namespace BotTest\TestCase\Http\Message;

use Bot\Http\Message\MessageFactory;
use Bot\Http\Message\SendMessageInterface;
use PHPUnit\Framework\TestCase;

final class MessageFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateReturnsSendMessageInstance(): void
    {
        $this->assertInstanceOf(SendMessageInterface::class, MessageFactory::create());
    }
}
