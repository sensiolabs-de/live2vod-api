<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Webmozart\Assert\Assert;

final class ClipErrorEvent implements WebhookEvent
{
    public readonly SessionId $sessionId;
    public readonly ClipId $clipId;
    public readonly Status $status;
    public readonly int $position;

    /**
     * @var array<string, mixed>
     */
    public readonly array $formData;
    public readonly ?Assets $assets;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        Assert::keyExists($data, 'sessionId');
        Assert::keyExists($data, 'clipId');
        Assert::keyExists($data, 'status');
        Assert::keyExists($data, 'position');
        Assert::keyExists($data, 'formData');

        $this->sessionId = new SessionId($data['sessionId']);
        $this->clipId = new ClipId($data['clipId']);

        Assert::string($data['status']);
        $this->status = Status::from($data['status']);

        Assert::integer($data['position']);
        $this->position = $data['position'];

        Assert::isArray($data['formData']);
        $this->formData = $data['formData'];

        if (isset($data['assets']) && \is_array($data['assets'])) {
            $this->assets = Assets::fromArray($data['assets']);
        } else {
            $this->assets = null;
        }
    }
}
