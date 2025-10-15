<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipCompletedEvent;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<ClipCompletedEvent>
 */
final class ClipCompletedEventFactory extends ObjectFactory
{
    /**
     * @return class-string<ClipCompletedEvent>
     */
    public static function class(): string
    {
        return ClipCompletedEvent::class;
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes): ClipCompletedEvent {
                return new ClipCompletedEvent($attributes);
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
