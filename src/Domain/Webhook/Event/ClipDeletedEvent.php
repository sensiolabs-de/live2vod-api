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
    public readonly int $position;
    public readonly bool $last;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        Assert::keyExists($data, 'sessionId');
        Assert::keyExists($data, 'clipId');
        Assert::keyExists($data, 'position');
        Assert::keyExists($data, 'last');

        $this->sessionId = new SessionId($data['sessionId']);
        $this->clipId = new ClipId($data['clipId']);

        Assert::integer($data['position']);
        $this->position = $data['position'];

        Assert::boolean($data['last']);
        $this->last = $data['last'];
    }
}
