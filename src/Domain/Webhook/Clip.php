<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type ClipArray array{
 *     clipId: string,
 *     status: string,
 *     position: int,
 *     formData: null|array<string, mixed>,
 *     assets: array<string, mixed>
 * }
 */
final class Clip
{
    /**
     * @param null|array<string, mixed> $formData
     */
    public function __construct(
        public readonly ClipId $clipId,
        public readonly Status $status,
        public readonly int $position,
        public readonly ?array $formData,
        public readonly Assets $assets,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'clipId');
        Assert::keyExists($data, 'status');
        Assert::keyExists($data, 'position');
        Assert::keyExists($data, 'formData');
        Assert::keyExists($data, 'assets');

        Assert::string($data['status']);
        Assert::integer($data['position']);
        Assert::nullOrIsArray($data['formData']);
        Assert::isArray($data['assets']);

        return new self(
            clipId: new ClipId($data['clipId']),
            status: Status::from($data['status']),
            position: $data['position'],
            formData: $data['formData'],
            assets: Assets::fromArray($data['assets']),
        );
    }

    /**
     * @return ClipArray
     */
    public function toArray(): array
    {
        return [
            'clipId' => $this->clipId->toString(),
            'status' => $this->status->value,
            'position' => $this->position,
            'formData' => $this->formData,
            'assets' => $this->assets->toArray(),
        ];
    }
}
