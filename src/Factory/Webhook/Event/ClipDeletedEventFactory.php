<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ArrayFactory;

final class ClipDeletedEventFactory extends ArrayFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'sessionId' => (string) new Ulid(),
            'clipId' => (string) new Ulid(),
            'position' => self::faker()->numberBetween(1, 10),
        ];
    }
}
