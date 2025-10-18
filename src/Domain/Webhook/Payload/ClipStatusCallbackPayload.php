<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook\Payload;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use SensioLabs\Live2Vod\Api\Domain\Clip\FormData;
use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event;

final class ClipStatusCallbackPayload
{
    public function __construct(
        public SessionId $sessionId,
        public Event $event,
        public ClipId $clipId,
        public Status $status,
        public int $position,
        public bool $last,
        public ?FormData $formData = null,
        public ?Assets $assets = null,
    ) {
    }
}
