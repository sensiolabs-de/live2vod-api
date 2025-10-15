<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Webhook;

use SensioLabs\Live2Vod\Api\Domain\Webhook\Event;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\WebhookEvent;

interface WebhookEventFactoryInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function create(Event $event, array $data): WebhookEvent;
}
