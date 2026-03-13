<?php

declare(strict_types=1);

namespace BotTest\TestCase\DTO;

use Bot\DTO\Message\ForwardOriginDTO;
use Bot\DTO\Message\UserDTO;
use PHPUnit\Framework\TestCase;

final class ForwardOriginDTOTest extends TestCase
{
    /**
     * @return void
     */
    public function testFromUserReturnsTrueOnlyForUserType(): void
    {
        $dto = ForwardOriginDTO::fromArray([
            'type' => 'user',
            'date' => 1700000000,
            'sender_user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Alice',
            ],
        ], false);

        $this->assertTrue($dto->fromUser());
        $this->assertFalse($dto->fromChannel());
        $this->assertInstanceOf(UserDTO::class, $dto->sender_user);
    }

    /**
     * @return void
     */
    public function testFromChannelReturnsTrueOnlyForChannelType(): void
    {
        $dto = ForwardOriginDTO::fromArray([
            'type' => 'channel',
            'date' => 1700000000,
            'chat' => [
                'id' => 100,
                'type' => 'channel',
                'title' => 'News',
            ],
            'message_id' => 55,
        ], false);

        $this->assertTrue($dto->fromChannel());
        $this->assertFalse($dto->fromUser());
        $this->assertSame(55, $dto->message_id);
    }

    /**
     * @return void
     */
    public function testValidateRequiresBaseFields(): void
    {
        $dto = ForwardOriginDTO::fromArray([], false);

        $this->expectException(\InvalidArgumentException::class);
        $dto->validate();
    }

    /**
     * @return void
     */
    public function testValidateRequiresSenderUserForUserType(): void
    {
        $dto = ForwardOriginDTO::fromArray([
            'type' => 'user',
            'date' => 1700000000,
        ], false);

        $this->expectException(\InvalidArgumentException::class);
        $dto->validate();
    }

    /**
     * @return void
     */
    public function testValidateRequiresSenderUserNameForHiddenUserType(): void
    {
        $dto = ForwardOriginDTO::fromArray([
            'type' => 'hidden_user',
            'date' => 1700000000,
        ], false);

        $this->expectException(\InvalidArgumentException::class);
        $dto->validate();
    }

    /**
     * @return void
     */
    public function testValidateRequiresSenderChatForChatType(): void
    {
        $dto = ForwardOriginDTO::fromArray([
            'type' => 'chat',
            'date' => 1700000000,
        ], false);

        $this->expectException(\InvalidArgumentException::class);
        $dto->validate();
    }

    /**
     * @return void
     */
    public function testValidateRequiresChatAndMessageIdForChannelType(): void
    {
        $dto = ForwardOriginDTO::fromArray([
            'type' => 'channel',
            'date' => 1700000000,
            'chat' => [
                'id' => 100,
                'type' => 'channel',
                'title' => 'News',
            ],
        ], false);

        $this->expectException(\InvalidArgumentException::class);
        $dto->validate();
    }
}
