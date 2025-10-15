<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipsFailedEvent;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<ClipsFailedEvent>
 */
final class ClipsFailedEventFactory extends ObjectFactory
{
    /**
     * @return class-string<ClipsFailedEvent>
     */
    public static function class(): string
    {
        return ClipsFailedEvent::class;
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes): ClipsFailedEvent {
                return new ClipsFailedEvent($attributes);
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
            'clips' => [],
        ];
    }
}
