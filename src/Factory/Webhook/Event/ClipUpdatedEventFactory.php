<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ArrayFactory;

final class ClipUpdatedEventFactory extends ArrayFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'sessionId' => (string) new Ulid(),
            'clipId' => (string) new Ulid(),
            'status' => Status::COMPLETED->value,
            'position' => self::faker()->numberBetween(1, 10),
            'formData' => [
                'title' => self::faker()->sentence(),
                'description' => self::faker()->optional()->paragraph(),
            ],
            'assets' => [
                'streams' => [],
                'files' => [],
                'thumbnail' => null,
            ],
        ];
    }
}
