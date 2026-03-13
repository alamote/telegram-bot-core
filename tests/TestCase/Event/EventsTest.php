<?php

declare(strict_types=1);

namespace BotTest\TestCase\Event;

use Bot\DTO\Update\CallbackQueryUpdateDTO;
use Bot\DTO\Update\MessageUpdateDTO;
use Bot\DTO\Update\UpdateDTO;
use Bot\Event\Events\ActionHandledEvent;
use Bot\Event\Events\CommandHandledEvent;
use Bot\Event\Events\ReceivedEvent;
use Bot\Event\Events\UnhandledEvent;
use BotTest\Fixture\TestActionWithAttribute;
use BotTest\Fixture\TestCommandWithAttribute;
use PHPUnit\Framework\TestCase;

final class EventsTest extends TestCase
{
    /**
     * @return void
     */
    public function testCommandHandledEventGetters(): void
    {
        $cmd = new TestCommandWithAttribute();
        $update = MessageUpdateDTO::fromArray(['message' => ['text' => '/start']], false);

        $event = new CommandHandledEvent($cmd, $update);

        $this->assertSame($cmd, $event->getCommand());
        $this->assertSame($update, $event->getUpdate());
    }

    /**
     * @return void
     */
    public function testActionHandledEventGetters(): void
    {
        $action = new TestActionWithAttribute();
        $update = CallbackQueryUpdateDTO::fromArray(['callback_query' => ['data' => 'confirm']], false);

        $event = new ActionHandledEvent($action, $update);

        $this->assertSame($action, $event->getAction());
        $this->assertSame($update, $event->getUpdate());
    }

    /**
     * @return void
     */
    public function testReceivedEventGetter(): void
    {
        $update = UpdateDTO::fromArray([], false);
        $event = new ReceivedEvent($update);

        $this->assertSame($update, $event->getUpdate());
    }

    /**
     * @return void
     */
    public function testUnhandledEventGetter(): void
    {
        $update = UpdateDTO::fromArray([], false);
        $event = new UnhandledEvent($update);

        $this->assertSame($update, $event->getUpdate());
    }
}
