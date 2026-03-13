<?php

declare(strict_types=1);

namespace BotTest\TestCase\DTO;

use Bot\DTO\Message\CallbackQueryDTO;
use Bot\DTO\Message\ChatDTO;
use Bot\DTO\Message\ContactDTO;
use Bot\DTO\Message\DocumentDTO;
use Bot\DTO\Message\LocationDTO;
use Bot\DTO\Message\PhotoSizeDTO;
use Bot\DTO\Message\UserDTO;
use Bot\DTO\Message\VideoDTO;
use Bot\DTO\Message\VideoNoteDTO;
use Bot\DTO\Message\VoiceDTO;
use PHPUnit\Framework\TestCase;

final class MessageLeafDTOsSmokeTest extends TestCase
{
    public function testLeafDtosCanBeInstantiatedFromArray(): void
    {
        $this->assertInstanceOf(ChatDTO::class, ChatDTO::fromArray([], false));
        $this->assertInstanceOf(ContactDTO::class, ContactDTO::fromArray([], false));
        $this->assertInstanceOf(DocumentDTO::class, DocumentDTO::fromArray([], false));
        $this->assertInstanceOf(LocationDTO::class, LocationDTO::fromArray([], false));
        $this->assertInstanceOf(PhotoSizeDTO::class, PhotoSizeDTO::fromArray([], false));
        $this->assertInstanceOf(UserDTO::class, UserDTO::fromArray([], false));
        $this->assertInstanceOf(VideoDTO::class, VideoDTO::fromArray([], false));
        $this->assertInstanceOf(VideoNoteDTO::class, VideoNoteDTO::fromArray([], false));
        $this->assertInstanceOf(VoiceDTO::class, VoiceDTO::fromArray([], false));
        $this->assertInstanceOf(CallbackQueryDTO::class, CallbackQueryDTO::fromArray([], false));
    }
}
