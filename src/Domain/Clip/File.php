<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

use SensioLabs\Live2Vod\Api\Domain\Clip\File\Bitrate;
use SensioLabs\Live2Vod\Api\Domain\Clip\File\FileType;
use SensioLabs\Live2Vod\Api\Domain\Url;

/**
 * @phpstan-type FileArray array{type: string, filepath: string, url: string, bitrate: int}
 */
final class File
{
    private FileType $type;

    public function __construct(
        private Filepath $filepath,
        private Bitrate $bitrate,
        private Url $url,
        ?FileType $type = null,
    ) {
        if (!$type instanceof FileType) {
            $extension = pathinfo($filepath->toString(), \PATHINFO_EXTENSION);

            $this->type = match (strtolower($extension)) {
                'mp4' => FileType::MP4,
                default => throw new \InvalidArgumentException(\sprintf('Unsupported file extension: %s', $extension)),
            };
        } else {
            $this->type = $type;
        }
    }

    public function getFilepath(): Filepath
    {
        return $this->filepath;
    }

    public function getBitrate(): Bitrate
    {
        return $this->bitrate;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getType(): FileType
    {
        return $this->type;
    }

    /**
     * @return FileArray
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'filepath' => $this->filepath->toString(),
            'url' => $this->url->toString(),
            'bitrate' => $this->bitrate->value,
        ];
    }
}
