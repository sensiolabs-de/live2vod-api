<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipDeletedEvent;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<ClipDeletedEvent>
 */
final class ClipDeletedEventFactory extends ObjectFactory
{
    /**
     * @return class-string<ClipDeletedEvent>
     */
    public static function class(): string
    {
        return ClipDeletedEvent::class;
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes): ClipDeletedEvent {
                return new ClipDeletedEvent($attributes);
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
        ];
    }
}
