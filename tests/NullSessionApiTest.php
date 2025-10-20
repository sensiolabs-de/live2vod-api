<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SensioLabs\Live2Vod\Api\Domain\Api\Request\CreateSessionRequest;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\CreateSessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\SessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use SensioLabs\Live2Vod\Api\Domain\Session\Config;
use SensioLabs\Live2Vod\Api\Domain\Session\Form;
use SensioLabs\Live2Vod\Api\Domain\Url;
use SensioLabs\Live2Vod\Api\NullSessionApi;

final class NullSessionApiTest extends TestCase
{
    #[Test]
    public function itCreatesSessionWithGeneratedId(): void
    {
        $api = new NullSessionApi();
        $request = new CreateSessionRequest(
            callbackUrl: new Url('https://example.com/callback'),
            form: new Form(),
            config: new Config(),
            metadata: [],
        );

        $response = $api->create($request);

        self::assertInstanceOf(CreateSessionResponse::class, $response);
        self::assertInstanceOf(SessionId::class, $response->id);
    }

    #[Test]
    public function itCreatesUniqueSessionIds(): void
    {
        $api = new NullSessionApi();
        $request = new CreateSessionRequest(
            callbackUrl: new Url('https://example.com/callback'),
            form: new Form(),
            config: new Config(),
            metadata: [],
        );

        $response1 = $api->create($request);
        $response2 = $api->create($request);

        self::assertNotSame($response1->id->toString(), $response2->id->toString());
    }

    #[Test]
    public function itGetsSessionWithProvidedId(): void
    {
        $api = new NullSessionApi();
        $sessionId = new SessionId();

        $response = $api->get($sessionId);

        self::assertInstanceOf(SessionResponse::class, $response);
        self::assertSame($sessionId, $response->id);
        self::assertInstanceOf(\DateTimeImmutable::class, $response->createdAt);
        self::assertInstanceOf(\DateTimeImmutable::class, $response->updatedAt);
        self::assertSame([], $response->config);
        self::assertSame([], $response->metadata);
        self::assertSame('https://example.com/callback', $response->callbackUrl);
        self::assertSame('orf1', $response->channel);
    }

    #[Test]
    public function itDeletesSessionWithoutError(): void
    {
        $api = new NullSessionApi();
        $sessionId = new SessionId();

        $api->delete($sessionId);

        $this->expectNotToPerformAssertions();
    }
}
