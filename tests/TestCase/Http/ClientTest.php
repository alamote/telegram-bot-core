<?php

declare(strict_types=1);

namespace BotTest\TestCase\Http;

use Bot\Http\Client;
use Bot\Http\Exception\TelegramException;
use Bot\Http\Message\SendMessageInterface;
use GuzzleHttp\Client as HttpClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class ClientTest extends TestCase
{
    /**
     * @return void
     * @throws TelegramException
     */
    public function testRequestReturnsDecodedArrayOnSuccess(): void
    {
        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')->willReturn('{"ok":true,"result":{"id":1}}');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($body);

        $http = $this->createMock(HttpClient::class);
        $http->expects($this->once())
             ->method('post')
             ->with('sendMessage', ['json' => ['chat_id' => 1, 'text' => 'hello']])
             ->willReturn($response);

        $client = new Client('token', [], $http);

        $result = $client->request('sendMessage', ['chat_id' => 1, 'text' => 'hello']);

        $this->assertTrue($result['ok']);
        $this->assertSame(1, $result['result']['id']);
    }

    /**
     * @return void
     * @throws TelegramException
     */
    public function testRequestThrowsTelegramExceptionOnInvalidJson(): void
    {
        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')->willReturn('{invalid');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($body);

        $http = $this->createMock(HttpClient::class);
        $http->method('post')->willReturn($response);

        $client = new Client('token', [], $http);

        $this->expectException(TelegramException::class);
        $client->request('sendMessage');
    }

    /**
     * @return void
     * @throws TelegramException
     */
    public function testRequestWrapsHttpFailureIntoTelegramException(): void
    {
        $http = $this->createMock(HttpClient::class);
        $http->method('post')->willThrowException(new \RuntimeException('network down'));

        $client = new Client('token', [], $http);

        $this->expectException(TelegramException::class);
        $this->expectExceptionMessage('HTTP request failed: network down');

        $client->request('sendMessage');
    }

    /**
     * @return void
     * @throws \Bot\Http\Exception\TelegramException
     */
    public function testSendMessageDelegatesToRequestPayload(): void
    {
        $message = $this->createMock(SendMessageInterface::class);
        $message->method('jsonSerialize')->willReturn(['chat_id' => 7, 'text' => 'yo']);

        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')->willReturn('{"ok":true}');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($body);

        $http = $this->createMock(HttpClient::class);
        $http->expects($this->once())
             ->method('post')
             ->with('sendMessage', ['json' => ['chat_id' => 7, 'text' => 'yo']])
             ->willReturn($response);

        $client = new Client('token', [], $http);

        $result = $client->sendMessage($message);

        $this->assertTrue($result['ok']);
    }

    /**
     * @return void
     * @throws \Bot\Http\Exception\TelegramException
     */
    public function testSetWebhookDelegatesToRequestPayload(): void
    {
        $body = $this->createMock(StreamInterface::class);
        $body->method('getContents')->willReturn('{"ok":true}');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($body);

        $http = $this->createMock(HttpClient::class);
        $http->expects($this->once())
             ->method('post')
             ->with('setWebhook', ['json' => ['url' => 'https://example.com/hook']])
             ->willReturn($response);

        $client = new Client('token', [], $http);

        $result = $client->setWebhook('https://example.com/hook');

        $this->assertTrue($result['ok']);
    }
}
