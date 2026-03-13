<?php

declare(strict_types=1);

namespace BotTest\TestCase\Listener;

use Bot\DTO\Update\UpdateDTO;
use Bot\Event\Events\UnhandledEvent;
use Bot\Listener\MessageListener;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class MessageListenerTest extends TestCase
{
    /**
     * @return void
     */
    public function testOnUnhandledEventLogsInfo(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('info');

        $listener = new MessageListener($logger);
        $update = UpdateDTO::fromArray([], false);
        $event = new UnhandledEvent($update);

        $listener->onUnhandledEvent($event);
    }
}
