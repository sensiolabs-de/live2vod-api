<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ClipApi implements ClipApiInterface
{
    public function __construct(
        private readonly ClientInterface $client,
    ) {
    }

    public function delete(ClipId $id, bool $suppressCallback = false): void
    {
        $options = [];

        if ($suppressCallback) {
            $options['headers'] = [
                'X-Suppress-Callback' => 'true',
            ];
        }

        $response = $this->client->request(
            Request::METHOD_DELETE,
            sprintf('api/clips/%s', $id),
            $options,
        );

        if (Response::HTTP_NOT_FOUND === $response->getStatusCode()) {
            // The clip is already gone, which is the desired end state of a delete.
            return;
        }

        // Triggers ClientExceptionInterface/ServerExceptionInterface for error responses,
        // which would otherwise be thrown lazily outside the caller's try/catch.
        $response->getHeaders();
    }
}
