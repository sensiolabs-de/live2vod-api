<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Webmozart\Assert\Assert;

final class ClipDeletedEvent implements WebhookEvent
{
    public readonly SessionId $sessionId;
    public readonly ClipId $clipId;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        Assert::keyExists($data, 'sessionId');
        Assert::keyExists($data, 'clipId');

        $this->sessionId = new SessionId($data['sessionId']);
        $this->clipId = new ClipId($data['clipId']);
    }
}
