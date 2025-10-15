<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Webmozart\Assert\Assert;

final class SessionDeletedEvent
{
    public readonly SessionId $sessionId;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        Assert::keyExists($data, 'sessionId');

        $this->sessionId = new SessionId($data['sessionId']);
    }
}
