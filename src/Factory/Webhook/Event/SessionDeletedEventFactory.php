<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\SessionDeletedEvent;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<SessionDeletedEvent>
 */
final class SessionDeletedEventFactory extends ObjectFactory
{
    /**
     * @return class-string<SessionDeletedEvent>
     */
    public static function class(): string
    {
        return SessionDeletedEvent::class;
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes): SessionDeletedEvent {
                return new SessionDeletedEvent($attributes);
            });
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'sessionId' => (string) new Ulid(),
        ];
    }
}
