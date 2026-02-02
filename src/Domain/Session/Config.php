<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session;

use SensioLabs\Live2Vod\Api\Domain\Title;
use SensioLabs\Live2Vod\Api\Domain\Url;
use OskarStark\Value\TrimmedNonEmptyString;
use Safe\DateTimeImmutable;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type ConfigArray array{
 *     channel: ?string,
 *     startTime: ?string,
 *     endTime: ?string,
 *     maxClips: ?int,
 *     title: ?string,
 *     cmsUrl: ?string,
 *     redSysUpload: bool
 * }
 */
final class Config implements \JsonSerializable
{
    public readonly ?string $channel;

    public function __construct(
        ?string $channel = null,
        public readonly ?\DateTimeImmutable $startTime = null,
        public readonly ?\DateTimeImmutable $endTime = null,
        public readonly ?int $maxClips = null,
        public readonly ?Title $title = null,
        public readonly ?Url $cmsUrl = null,
        public readonly bool $redSysUpload = false,
    ) {
        $this->channel = null !== $channel ? TrimmedNonEmptyString::fromString($channel)->toString() : null;

        if (null !== $maxClips) {
            Assert::greaterThan($maxClips, 0, 'Max clips must be at least 1');
        }

        if ($endTime instanceof \DateTimeImmutable) {
            Assert::notNull($startTime, 'End time can only be specified with start time');
            Assert::greaterThan($endTime, $startTime, 'End time must be after start time');
        }
    }

    /**
     * @return ConfigArray
     */
    public function toArray(): array
    {
        return [
            'channel' => $this->channel,
            'startTime' => $this->startTime?->format(\DateTimeInterface::ATOM),
            'endTime' => $this->endTime?->format(\DateTimeInterface::ATOM),
            'maxClips' => $this->maxClips,
            'title' => $this->title?->toString(),
            'cmsUrl' => $this->cmsUrl?->toString(),
            'redSysUpload' => $this->redSysUpload,
        ];
    }

    /**
     * @param array{
     *     channel?: ?string,
     *     startTime?: ?string,
     *     endTime?: ?string,
     *     maxClips?: ?int,
     *     title?: ?string,
     *     cmsUrl?: ?string,
     *     redSysUpload?: bool
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            channel: $data['channel'] ?? null,
            startTime: isset($data['startTime']) ? new DateTimeImmutable($data['startTime']) : null,
            endTime: isset($data['endTime']) ? new DateTimeImmutable($data['endTime']) : null,
            maxClips: $data['maxClips'] ?? null,
            title: isset($data['title']) ? new Title($data['title']) : null,
            cmsUrl: isset($data['cmsUrl']) ? new Url($data['cmsUrl']) : null,
            redSysUpload: $data['redSysUpload'] ?? false,
        );
    }

    /**
     * @return ConfigArray
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function isRedSysUploadEnabled(): bool
    {
        return $this->redSysUpload;
    }
}
