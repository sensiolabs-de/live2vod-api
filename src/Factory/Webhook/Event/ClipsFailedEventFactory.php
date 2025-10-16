<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ArrayFactory;

final class ClipsFailedEventFactory extends ArrayFactory
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
            'clips' => [],
        ];
    }
}
