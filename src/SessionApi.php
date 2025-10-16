<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use App\Domain\Api\Request\CreateSessionRequest;
use App\Domain\Api\Response\CreateSessionResponse;
use App\Domain\Api\Response\SessionResponse;
use App\Domain\Identifier\SessionId;
use Symfony\Component\HttpFoundation\Request;

final class SessionApi implements SessionApiInterface
{
    public function __construct(
        private readonly ClientInterface $client,
    ) {
    }

    public function create(CreateSessionRequest $request): CreateSessionResponse
    {
        $response = $this->client->request(Request::METHOD_POST, 'api/sessions', [
            'json' => $request,
        ]);

        return CreateSessionResponse::fromArray($response->toArray());
    }

    public function get(SessionId $id): SessionResponse
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('api/sessions/%s', $id),
        );

        return SessionResponse::fromArray($response->toArray());
    }

    public function delete(SessionId $id): void
    {
        $this->client->request(
            Request::METHOD_DELETE,
            sprintf('api/sessions/%s', $id),
        );
    }
}
