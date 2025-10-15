<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipUpdatedEvent;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<ClipUpdatedEvent>
 */
final class ClipUpdatedEventFactory extends ObjectFactory
{
    /**
     * @return class-string<ClipUpdatedEvent>
     */
    public static function class(): string
    {
        return ClipUpdatedEvent::class;
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes): ClipUpdatedEvent {
                return new ClipUpdatedEvent($attributes);
            });
    }

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
