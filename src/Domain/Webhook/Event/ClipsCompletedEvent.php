<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Clip;
use Webmozart\Assert\Assert;

final class ClipsCompletedEvent implements WebhookEvent
{
    public SessionId $sessionId;

    /**
     * @var array<string, null|bool|float|int|string>
     */
    public array $metadata;

    /**
     * @var array<int, Clip>
     */
    public array $clips;

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
        $clips = [];

        foreach ($data['clips'] as $clipData) {
            Assert::isArray($clipData);
            $clips[] = Clip::fromArray($clipData);
        }

        $this->clips = $clips;
    }
}
