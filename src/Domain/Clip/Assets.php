<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

use SensioLabs\Live2Vod\Api\Domain\Clip\Exception\FileNotFoundException;
use SensioLabs\Live2Vod\Api\Domain\Clip\Exception\StreamNotFoundException;
use SensioLabs\Live2Vod\Api\Domain\Clip\File\Bitrate;
use SensioLabs\Live2Vod\Api\Domain\Clip\File\FileType;
use SensioLabs\Live2Vod\Api\Domain\DRM\Token;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use SensioLabs\Live2Vod\Api\Domain\Url;

/**
 * @phpstan-import-type StreamArray from Stream
 * @phpstan-import-type FileArray from File
 *
 * @phpstan-type AssetsArray array{streams: array<StreamArray>, files: array<FileArray>, thumbnail: null|string}
 */
final class Assets
{
    /**
     * @param array<Stream> $streams
     * @param array<File>   $files
     */
    public function __construct(
        private array $streams = [],
        private array $files = [],
        private ?Thumbnail $thumbnail = null,
    ) {
    }

    /**
     * @return array<Stream>
     */
    public function getStreams(): array
    {
        return $this->streams;
    }

    /**
     * @return array<File>
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    public function getThumbnail(): ?Thumbnail
    {
        return $this->thumbnail;
    }

    /**
     * @param array{streams?: array<StreamArray>, files?: array<FileArray>, thumbnail?: null|non-empty-string} $data
     */
    public static function fromArray(array $data): self
    {
        $streams = [];

        if (isset($data['streams'])) {
            foreach ($data['streams'] as $streamData) {
                $streams[] = Stream::fromArray($streamData);
            }
        }

        $files = [];

        if (isset($data['files'])) {
            foreach ($data['files'] as $fileData) {
                $files[] = new File(
                    filepath: new Filepath($fileData['filepath']),
                    bitrate: Bitrate::from($fileData['bitrate']),
                    url: new Url($fileData['url']),
                    type: FileType::from($fileData['type']),
                );
            }
        }

        return new self(
            streams: $streams,
            files: $files,
            thumbnail: \array_key_exists('thumbnail', $data) && null !== $data['thumbnail'] ? new Thumbnail($data['thumbnail']) : null,
        );
    }

    /**
     * @return AssetsArray
     */
    public function toArray(): array
    {
        return [
            'streams' => array_map(static fn (Stream $stream) => $stream->toArray(), $this->streams),
            'files' => array_map(static fn (File $file) => $file->toArray(), $this->files),
            'thumbnail' => $this->thumbnail?->toString(),
        ];
    }

    /**
     * @param array<Stream> $streams
     */
    public function withStreams(array $streams): self
    {
        return new self(
            streams: $streams,
            files: $this->files,
            thumbnail: $this->thumbnail,
        );
    }

    /**
     * @param array<File> $files
     */
    public function withFiles(array $files): self
    {
        return new self(
            streams: $this->streams,
            files: $files,
            thumbnail: $this->thumbnail,
        );
    }

    public function withThumbnail(?Thumbnail $thumbnail): self
    {
        return new self(
            streams: $this->streams,
            files: $this->files,
            thumbnail: $thumbnail,
        );
    }

    public function addStream(Stream $stream): self
    {
        $streams = $this->streams;
        $streams[] = $stream;

        return new self(
            streams: $streams,
            files: $this->files,
            thumbnail: $this->thumbnail,
        );
    }

    public function addMp4(File $file): self
    {
        $files = $this->files;
        $files[] = $file;

        return new self(
            streams: $this->streams,
            files: $files,
            thumbnail: $this->thumbnail,
        );
    }

    public function hasThumbnail(): bool
    {
        return null !== $this->thumbnail;
    }

    /**
     * @throws FileNotFoundException
     */
    public function getFileByBitrate(Bitrate $bitrate, ClipId $clipId): File
    {
        if ([] === $this->files) {
            throw FileNotFoundException::noFiles($clipId);
        }

        foreach ($this->files as $file) {
            if ($file->getBitrate()->equals($bitrate)) {
                return $file;
            }
        }

        throw FileNotFoundException::forBitrate($bitrate, $clipId);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getHighestByBitrate(ClipId $clipId): File
    {
        if ([] === $this->files) {
            throw FileNotFoundException::noFiles($clipId);
        }

        $highest = null;

        foreach ($this->files as $file) {
            if (null === $highest || $file->getBitrate()->value > $highest->getBitrate()->value) {
                $highest = $file;
            }
        }

        return $highest;
    }

    /**
     * @throws FileNotFoundException
     */
    public function getLowestByBitrate(ClipId $clipId): File
    {
        if ([] === $this->files) {
            throw FileNotFoundException::noFiles($clipId);
        }

        $lowest = null;

        foreach ($this->files as $file) {
            if (null === $lowest || $file->getBitrate()->value < $lowest->getBitrate()->value) {
                $lowest = $file;
            }
        }

        return $lowest;
    }

    /**
     * Returns a new Assets instance with the token appended to all stream URLs.
     * Files and thumbnail remain unchanged.
     */
    public function withToken(Token $token): self
    {
        $streamsWithToken = array_map(
            static fn (Stream $stream): Stream => $stream->withToken($token),
            $this->streams,
        );

        return new self(
            streams: $streamsWithToken,
            files: $this->files,
            thumbnail: $this->thumbnail,
        );
    }

    /**
     * @throws StreamNotFoundException
     */
    public function getStreamByType(StreamType $type, ClipId $clipId): Stream
    {
        if ([] === $this->streams) {
            throw StreamNotFoundException::noStreams($clipId);
        }

        foreach ($this->streams as $stream) {
            if ($stream->getType()->equals($type)) {
                return $stream;
            }
        }

        throw StreamNotFoundException::forType($type, $clipId);
    }
}
