<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SensioLabs\Live2Vod\Api\ClientInterface;
use SensioLabs\Live2Vod\Api\Domain\Api\Request\CreateSessionRequest;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\CreateSessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\SessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use SensioLabs\Live2Vod\Api\Domain\Session\Config;
use SensioLabs\Live2Vod\Api\Domain\Session\Form;
use SensioLabs\Live2Vod\Api\Domain\Url;
use SensioLabs\Live2Vod\Api\SessionApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SessionApiTest extends TestCase
{
    #[Test]
    public function create(): void
    {
        $sessionId = '01JAXRHM7JZSP4Y4PXSACN8CPT';
        $callbackUrl = new Url('https://example.com/callback');
        $form = Form::fromArray([
            'title' => [
                'type' => 'text',
                'label' => 'Title',
                'required' => true,
            ],
        ]);
        $config = Config::fromArray([
            'channel' => 'oe1',
            'recordingId' => 'abc123',
        ]);

        $createRequest = new CreateSessionRequest(
            callbackUrl: $callbackUrl,
            form: $form,
            config: $config,
            metadata: ['key' => 'value'],
        );

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects(self::once())
            ->method('toArray')
            ->willReturn(['id' => $sessionId]);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects(self::once())
            ->method('request')
            ->with(
                method: Request::METHOD_POST,
                url: 'api/sessions',
                options: [
                    'json' => $createRequest,
                ],
            )
            ->willReturn($response);

        $api = new SessionApi(client: $client);
        $result = $api->create(request: $createRequest);

        self::assertInstanceOf(CreateSessionResponse::class, $result);
        self::assertSame($sessionId, $result->id->toString());
    }

    #[Test]
    public function get(): void
    {
        $sessionId = new SessionId('01JAXRHM7JZSP4Y4PXSACN8CPT');
        $responseData = [
            'id' => '01JAXRHM7JZSP4Y4PXSACN8CPT',
            'createdAt' => '2025-10-20T12:00:00+00:00',
            'updatedAt' => '2025-10-20T12:30:00+00:00',
            'config' => [
                'channel' => 'oe1',
                'recordingId' => 'abc123',
            ],
            'metadata' => ['key' => 'value'],
            'callbackUrl' => 'https://example.com/callback',
            'channel' => 'oe1',
        ];

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects(self::once())
            ->method('toArray')
            ->willReturn($responseData);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects(self::once())
            ->method('request')
            ->with(
                method: Request::METHOD_GET,
                url: 'api/sessions/01JAXRHM7JZSP4Y4PXSACN8CPT',
            )
            ->willReturn($response);

        $api = new SessionApi(client: $client);
        $result = $api->get(id: $sessionId);

        self::assertInstanceOf(SessionResponse::class, $result);
        self::assertSame('01JAXRHM7JZSP4Y4PXSACN8CPT', $result->id->toString());
        self::assertSame('2025-10-20T12:00:00+00:00', $result->createdAt->format(\DateTimeInterface::ATOM));
        self::assertSame('2025-10-20T12:30:00+00:00', $result->updatedAt->format(\DateTimeInterface::ATOM));
        self::assertSame(['channel' => 'oe1', 'recordingId' => 'abc123'], $result->config);
        self::assertSame(['key' => 'value'], $result->metadata);
        self::assertSame('https://example.com/callback', $result->callbackUrl);
        self::assertSame('oe1', $result->channel);
    }

    #[Test]
    public function delete(): void
    {
        $sessionId = new SessionId('01JAXRHM7JZSP4Y4PXSACN8CPT');

        $response = self::createStub(ResponseInterface::class);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects(self::once())
            ->method('request')
            ->with(
                method: Request::METHOD_DELETE,
                url: 'api/sessions/01JAXRHM7JZSP4Y4PXSACN8CPT',
            )
            ->willReturn($response);

        $api = new SessionApi(client: $client);
        $api->delete(id: $sessionId);
    }
}
