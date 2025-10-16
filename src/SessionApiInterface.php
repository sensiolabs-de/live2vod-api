<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use App\Domain\Api\Request\CreateSessionRequest;
use App\Domain\Api\Response\CreateSessionResponse;
use App\Domain\Api\Response\SessionResponse;
use App\Domain\Identifier\SessionId;

interface SessionApiInterface
{
    public function create(CreateSessionRequest $request): CreateSessionResponse;

    public function get(SessionId $id): SessionResponse;

    public function delete(SessionId $id): void;
}
