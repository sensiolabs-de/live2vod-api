<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Webhook;

use SensioLabs\Live2Vod\Api\Domain\Webhook\Event;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipCompletedEvent;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipDeletedEvent;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipErrorEvent;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipsCompletedEvent;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipsFailedEvent;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipUpdatedEvent;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\SessionDeletedEvent;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\WebhookEvent;

final readonly class WebhookEventFactory implements WebhookEventFactoryInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function create(Event $event, array $data): WebhookEvent
    {
        return match ($event) {
            Event::CLIP_COMPLETED => new ClipCompletedEvent($data),
            Event::CLIP_DELETED => new ClipDeletedEvent($data),
            Event::CLIP_ERROR => new ClipErrorEvent($data),
            Event::CLIP_UPDATED => new ClipUpdatedEvent($data),
            Event::CLIPS_COMPLETED => new ClipsCompletedEvent($data),
            Event::CLIPS_FAILED => new ClipsFailedEvent($data),
            Event::SESSION_DELETED => new SessionDeletedEvent($data),
        };
    }
}
