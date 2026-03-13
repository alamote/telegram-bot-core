<?php

declare(strict_types=1);

namespace BotTest\TestCase\DTO;

use BotTest\Fixture\TestChildDTO;
use BotTest\Fixture\TestParentDTO;
use PHPUnit\Framework\TestCase;

final class DTOTest extends TestCase
{
    /**
     * @return void
     */
    public function testFromArrayMapsScalarsAndNestedDto(): void
    {
        $dto = TestParentDTO::fromArray([
            'id' => '42',
            'name' => 123,
            'child' => [
                'value' => 'nested',
            ],
        ]);

        $this->assertInstanceOf(TestChildDTO::class, $dto->child);
        $this->assertSame(42, $dto->id);
        $this->assertSame('123', $dto->name);
        $this->assertSame('nested', $dto->child->value);
    }

    /**
     * @return void
     */
    public function testUnknownPropertiesAreStoredAsOptionsAndReturnedByGet(): void
    {
        $dto = TestParentDTO::fromArray([
            'unknown_key' => 'hello',
        ], false);

        $this->assertSame('hello', $dto->get('unknown_key'));
    }

    /**
     * @return void
     */
    public function testToArrayContainsKnownAndOptionProperties(): void
    {
        $dto = TestParentDTO::fromArray([
            'id' => 7,
            'name' => 'john',
            'unknown_key' => 'extra',
            'child' => [
                'value' => 'x',
            ],
        ]);

        $arr = $dto->toArray();

        $this->assertSame(7, $arr['id']);
        $this->assertSame('john', $arr['name']);
        $this->assertSame('extra', $arr['unknown_key']);
        $this->assertSame(['value' => 'x'], $arr['child']);
    }

    /**
     * @return void
     */
    public function testDefaultCreatesDtoWithoutValidation(): void
    {
        $dto = TestParentDTO::default();

        $this->assertInstanceOf(TestParentDTO::class, $dto);
    }
}
