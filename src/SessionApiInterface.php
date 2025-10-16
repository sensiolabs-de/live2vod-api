<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use SensioLabs\Live2Vod\Api\Domain\Api\Request\CreateSessionRequest;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\CreateSessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\SessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;

interface SessionApiInterface
{
    public function create(CreateSessionRequest $request): CreateSessionResponse;

    public function get(SessionId $id): SessionResponse;

    public function delete(SessionId $id): void;
}
