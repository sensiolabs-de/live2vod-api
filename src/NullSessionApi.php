<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use SensioLabs\Live2Vod\Api\Domain\Api\Request\CreateSessionRequest;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\CreateSessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\SessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Safe\DateTimeImmutable;

final class NullSessionApi implements SessionApiInterface
{
    public function create(CreateSessionRequest $request): CreateSessionResponse
    {
        return new CreateSessionResponse(
            id: new SessionId(),
        );
    }

    public function get(SessionId $id): SessionResponse
    {
        return new SessionResponse(
            id: $id,
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable(),
            config: [],
            metadata: [],
            callbackUrl: 'https://example.com/callback',
            channel: 'orf1',
        );
    }

    public function delete(SessionId $id): void
    {
    }
}
