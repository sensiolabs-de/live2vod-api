<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipsCompletedEvent;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<ClipsCompletedEvent>
 */
final class ClipsCompletedEventFactory extends ObjectFactory
{
    /**
     * @return class-string<ClipsCompletedEvent>
     */
    public static function class(): string
    {
        return ClipsCompletedEvent::class;
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes): ClipsCompletedEvent {
                return new ClipsCompletedEvent($attributes);
            });
    }

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
