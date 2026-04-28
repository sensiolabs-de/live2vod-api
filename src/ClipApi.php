<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use Symfony\Component\HttpFoundation\Request;

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

        $this->client->request(
            Request::METHOD_DELETE,
            sprintf('api/clips/%s', $id),
            $options,
        );
    }
}
