<?php

declare(strict_types=1);

namespace BotTest\TestCase\Config;

use Bot\Config\ConfigService;
use PHPUnit\Framework\TestCase;

final class ConfigServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstructorStoresOptions(): void
    {
        $cfg = new ConfigService(['a' => 1, 'b' => 'x']);

        $this->assertSame(1, $cfg->getOption('a'));
        $this->assertSame('x', $cfg->getOption('b'));
    }
}
