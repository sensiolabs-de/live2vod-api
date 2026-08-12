<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SensioLabs\Live2Vod\Api\Client;
use SensioLabs\Live2Vod\Api\ClipApi;
use SensioLabs\Live2Vod\Api\ClientInterface;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ClipApiTest extends TestCase
{
    #[Test]
    public function delete(): void
    {
        $clipId = new ClipId('01JAXRHM7JZSP4Y4PXSACN8CPT');

        $response = self::createStub(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(204);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects(self::once())
            ->method('request')
            ->with(
                method: Request::METHOD_DELETE,
                url: 'api/clips/01JAXRHM7JZSP4Y4PXSACN8CPT',
                options: [],
            )
            ->willReturn($response);

        $api = new ClipApi(client: $client);
        $api->delete(id: $clipId);
    }

    #[Test]
    public function deleteWithSuppressCallback(): void
    {
        $clipId = new ClipId('01JAXRHM7JZSP4Y4PXSACN8CPT');

        $response = self::createStub(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(204);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects(self::once())
            ->method('request')
            ->with(
                method: Request::METHOD_DELETE,
                url: 'api/clips/01JAXRHM7JZSP4Y4PXSACN8CPT',
                options: [
                    'headers' => [
                        'X-Suppress-Callback' => 'true',
                    ],
                ],
            )
            ->willReturn($response);

        $api = new ClipApi(client: $client);
        $api->delete(id: $clipId, suppressCallback: true);
    }

    #[Test]
    public function deleteDoesNotThrowWhenClipDoesNotExist(): void
    {
        $mockResponse = new MockResponse(info: ['http_code' => 404]);

        $client = new Client(baseUri: 'https://example.com/');
        $client->withHttpClient(new MockHttpClient($mockResponse, 'https://example.com/'));

        $api = new ClipApi(client: $client);
        $api->delete(id: new ClipId('01JAXRHM7JZSP4Y4PXSACN8CPT'));

        self::assertSame('DELETE', $mockResponse->getRequestMethod());
    }

    #[Test]
    public function deleteThrowsOnClientError(): void
    {
        $mockResponse = new MockResponse(info: ['http_code' => 403]);

        $client = new Client(baseUri: 'https://example.com/');
        $client->withHttpClient(new MockHttpClient($mockResponse, 'https://example.com/'));

        $api = new ClipApi(client: $client);

        $this->expectException(ClientExceptionInterface::class);

        $api->delete(id: new ClipId('01JAXRHM7JZSP4Y4PXSACN8CPT'));
    }

    #[Test]
    public function deleteThrowsOnServerError(): void
    {
        $mockResponse = new MockResponse(info: ['http_code' => 500]);

        $client = new Client(baseUri: 'https://example.com/');
        $client->withHttpClient(new MockHttpClient($mockResponse, 'https://example.com/'));

        $api = new ClipApi(client: $client);

        $this->expectException(ServerExceptionInterface::class);

        $api->delete(id: new ClipId('01JAXRHM7JZSP4Y4PXSACN8CPT'));
    }
}
