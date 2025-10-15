<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook\Payload;

use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event;

final class ClipDeletedCallbackPayload
{
    public function __construct(
        public SessionId $sessionId,
        public Event $event,
        public ClipId $clipId,
        public int $position,
    ) {
    }
}
