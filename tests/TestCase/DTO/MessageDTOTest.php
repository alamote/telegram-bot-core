<?php

declare(strict_types=1);

namespace BotTest\TestCase\DTO;

use Bot\DTO\Message\MessageDTO;
use Bot\Enum\MessageMediaType;
use PHPUnit\Framework\TestCase;

final class MessageDTOTest extends TestCase
{
    /**
     * @return void
     */
    public function testFromArrayMapsPhotoAndIsMedia(): void
    {
        $dto = MessageDTO::fromArray([
            'message_id' => 1,
            'photo' => [['file_id' => 'f1', 'file_unique_id' => 'u1', 'width' => 10, 'height' => 10]],
        ], false);

        $this->assertTrue($dto->isMedia());
        $this->assertSame(MessageMediaType::PHOTO, $dto->getMediaType());
    }

    /**
     * @return void
     */
    public function testGetMediaTypeReturnsNullWhenNoMedia(): void
    {
        $dto = MessageDTO::fromArray(['message_id' => 1], false);

        $this->assertNull($dto->getMediaType());
        $this->assertFalse($dto->isMedia());
    }
}
