<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipCreatedEvent;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<ClipCreatedEvent>
 */
final class ClipCreatedEventFactory extends ObjectFactory
{
    /**
     * @return class-string<ClipCreatedEvent>
     */
    public static function class(): string
    {
        return ClipCreatedEvent::class;
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes): ClipCreatedEvent {
                return new ClipCreatedEvent($attributes);
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
            'position' => self::faker()->numberBetween(1, 10),
            'formData' => [
                'title' => self::faker()->sentence(),
                'description' => self::faker()->optional()->paragraph(),
            ],
        ];
    }
}
