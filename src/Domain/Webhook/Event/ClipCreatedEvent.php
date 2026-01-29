<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Safe\DateTimeImmutable;
use Webmozart\Assert\Assert;

final class ClipCreatedEvent implements WebhookEvent
{
    public SessionId $sessionId;
    public ClipId $clipId;
    public int $position;
    public bool $last;
    public DateTimeImmutable $markIn;
    public DateTimeImmutable $markOut;

    /**
     * @var array<string, mixed>
     */
    public array $formData;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        Assert::keyExists($data, 'sessionId');
        Assert::keyExists($data, 'clipId');
        Assert::keyExists($data, 'position');
        Assert::keyExists($data, 'last');
        Assert::keyExists($data, 'markIn');
        Assert::keyExists($data, 'markOut');
        Assert::keyExists($data, 'formData');

        $this->sessionId = new SessionId($data['sessionId']);
        $this->clipId = new ClipId($data['clipId']);

        Assert::integer($data['position']);
        $this->position = $data['position'];

        Assert::boolean($data['last']);
        $this->last = $data['last'];

        Assert::string($data['markIn']);
        $this->markIn = new DateTimeImmutable($data['markIn']);

        Assert::string($data['markOut']);
        $this->markOut = new DateTimeImmutable($data['markOut']);

        Assert::isArray($data['formData']);
        $this->formData = $data['formData'];
    }
}
