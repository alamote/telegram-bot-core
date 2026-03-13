<?php

declare(strict_types=1);

namespace BotTest\TestCase\Middleware;

use Bot\Config\ConfigServiceInterface;
use Bot\DTO\Update\UpdateDTO;
use Bot\Middleware\Middlewares\MaintenanceMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class MaintenanceMiddlewareTest extends TestCase
{
    /**
     * @return void
     * @throws \Bot\Http\Exception\TelegramException
     */
    public function testProcessCallsNextWhenChatIdIsNull(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $config = $this->createMock(ConfigServiceInterface::class);
        $config->expects($this->never())->method('getOption');

        $update = $this->createMock(UpdateDTO::class);
        $update->method('getChatId')->willReturn(null);
        $update->expects($this->never())->method('reply');

        $mw = new MaintenanceMiddleware($config, $logger);

        $called = false;
        $mw->process($update, function () use (&$called): void {
            $called = true;
        });

        $this->assertTrue($called);
    }

    /**
     * @return void
     * @throws \Bot\Http\Exception\TelegramException
     */
    public function testProcessCallsNextWhenMaintenanceDisabled(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $config = $this->createMock(ConfigServiceInterface::class);
        $config->expects($this->once())->method('getOption')->with('maintenance.enabled')->willReturn(false);

        $update = $this->createMock(UpdateDTO::class);
        $update->method('getChatId')->willReturn(123);
        $update->expects($this->never())->method('reply');

        $mw = new MaintenanceMiddleware($config, $logger);

        $called = false;
        $mw->process($update, function () use (&$called): void {
            $called = true;
        });

        $this->assertTrue($called);
    }

    /**
     * @return void
     * @throws \Bot\Http\Exception\TelegramException
     */
    public function testProcessRepliesAndStopsWhenMaintenanceEnabled(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $config = $this->createMock(ConfigServiceInterface::class);
        $config->expects($this->once())->method('getOption')->with('maintenance.enabled')->willReturn(true);

        $update = $this->createMock(UpdateDTO::class);
        $update->method('getChatId')->willReturn(123);
        $update->expects($this->once())->method('reply');

        $mw = new MaintenanceMiddleware($config, $logger);

        $called = false;
        $mw->process($update, function () use (&$called): void {
            $called = true;
        });

        $this->assertFalse($called);
    }

    /**
     * @return void
     * @throws \Bot\Http\Exception\TelegramException
     */
    public function testProcessLogsErrorWhenReplyThrows(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('error');

        $config = $this->createMock(ConfigServiceInterface::class);
        $config->method('getOption')->with('maintenance.enabled')->willReturn(true);

        $update = $this->createMock(UpdateDTO::class);
        $update->method('getChatId')->willReturn(123);
        $update->method('reply')->willThrowException(new \RuntimeException('boom'));

        $mw = new MaintenanceMiddleware($config, $logger);

        $called = false;
        $mw->process($update, function () use (&$called): void {
            $called = true;
        });

        $this->assertFalse($called);
    }
}
