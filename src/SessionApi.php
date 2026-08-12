<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use SensioLabs\Live2Vod\Api\Domain\Api\Request\CreateSessionRequest;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\CreateSessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Api\Response\SessionResponse;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $response = $this->client->request(
            Request::METHOD_DELETE,
            sprintf('api/sessions/%s', $id),
        );

        if (Response::HTTP_NOT_FOUND === $response->getStatusCode()) {
            // The session is already gone, which is the desired end state of a delete.
            return;
        }

        // Triggers ClientExceptionInterface/ServerExceptionInterface for error responses,
        // which would otherwise be thrown lazily outside the caller's try/catch.
        $response->getHeaders();
    }
}
