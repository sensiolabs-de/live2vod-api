<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Webmozart\Assert\Assert;

final class ClipsFailedEvent
{
    public readonly SessionId $sessionId;

    /**
     * @var array<string, null|bool|float|int|string>
     */
    public readonly array $metadata;

    /**
     * @var array<mixed>
     */
    public readonly array $clips;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        Assert::keyExists($data, 'sessionId');
        Assert::keyExists($data, 'metadata');
        Assert::keyExists($data, 'clips');

        $this->sessionId = new SessionId($data['sessionId']);

        Assert::isArray($data['metadata']);
        $this->metadata = $data['metadata'];

        Assert::isArray($data['clips']);
        $this->clips = $data['clips'];
    }
}
