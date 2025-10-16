<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ArrayFactory;

final class ClipsCompletedEventFactory extends ArrayFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'sessionId' => (string) new Ulid(),
            'metadata' => [
                'source' => self::faker()->randomElement(['cms', 'api', 'manual']),
                'version' => self::faker()->semver(),
            ],
            'clips' => [
                [
                    'clipId' => (string) new Ulid(),
                    'status' => Status::COMPLETED->value,
                    'position' => 1,
                    'formData' => [
                        'title' => self::faker()->sentence(),
                    ],
                    'assets' => [
                        'streams' => [],
                        'files' => [],
                        'thumbnail' => null,
                    ],
                ],
                [
                    'clipId' => (string) new Ulid(),
                    'status' => Status::COMPLETED->value,
                    'position' => 2,
                    'formData' => [
                        'title' => self::faker()->sentence(),
                    ],
                    'assets' => [
                        'streams' => [],
                        'files' => [],
                        'thumbnail' => null,
                    ],
                ],
            ],
        ];
    }
}
