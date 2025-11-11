<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use SensioLabs\Live2Vod\Api\Domain\Clip\File;
use SensioLabs\Live2Vod\Api\Domain\Clip\File\Bitrate;
use SensioLabs\Live2Vod\Api\Domain\Clip\Filepath;
use SensioLabs\Live2Vod\Api\Domain\Clip\Stream;
use SensioLabs\Live2Vod\Api\Domain\Clip\StreamType;
use SensioLabs\Live2Vod\Api\Domain\Clip\Thumbnail;
use SensioLabs\Live2Vod\Api\Domain\Url;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<Assets>
 */
final class AssetsFactory extends ObjectFactory
{
    public static function class(): string
    {
        return Assets::class;
    }

    public static function empty(): self
    {
        return self::new([
            'streams' => [],
            'files' => [],
            'thumbnail' => null,
        ]);
    }

    /**
     * @return array{streams: array<Stream>, files: array<File>, thumbnail: Thumbnail}
     */
    protected function defaults(): array
    {
        $videoId = self::faker()->uuid();
        $baseUrl = self::faker()->url();

        $files = [
            new File(
                filepath: new Filepath(\sprintf('videos/%s/video_496400.mp4', $videoId)),
                bitrate: Bitrate::BITRATE_496400,
                url: new Url(\sprintf('%s/videos/%s/video_496400.mp4', $baseUrl, $videoId)),
            ),
            new File(
                filepath: new Filepath(\sprintf('videos/%s/video_789600.mp4', $videoId)),
                bitrate: Bitrate::BITRATE_789600,
                url: new Url(\sprintf('%s/videos/%s/video_789600.mp4', $baseUrl, $videoId)),
            ),
            new File(
                filepath: new Filepath(\sprintf('videos/%s/video_1639600.mp4', $videoId)),
                bitrate: Bitrate::BITRATE_1639600,
                url: new Url(\sprintf('%s/videos/%s/video_1639600.mp4', $baseUrl, $videoId)),
            ),
            new File(
                filepath: new Filepath(\sprintf('videos/%s/video_3020800.mp4', $videoId)),
                bitrate: Bitrate::BITRATE_3020800,
                url: new Url(\sprintf('%s/videos/%s/video_3020800.mp4', $baseUrl, $videoId)),
            ),
            new File(
                filepath: new Filepath(\sprintf('videos/%s/video_5299600.mp4', $videoId)),
                bitrate: Bitrate::BITRATE_5299600,
                url: new Url(\sprintf('%s/videos/%s/video_5299600.mp4', $baseUrl, $videoId)),
            ),
        ];

        $streams = [
            new Stream(
                type: StreamType::HLS,
                url: new Url(\sprintf('%s/videos/%s/index.m3u8', $baseUrl, $videoId)),
            ),
            new Stream(
                type: StreamType::HLS_DRM,
                url: new Url(\sprintf('%s/videos/%s/index_drm.m3u8', $baseUrl, $videoId)),
            ),
            new Stream(
                type: StreamType::DASH,
                url: new Url(\sprintf('%s/videos/%s/manifest.mpd', $baseUrl, $videoId)),
            ),
            new Stream(
                type: StreamType::DASH_DRM,
                url: new Url(\sprintf('%s/videos/%s/manifest_drm.mpd', $baseUrl, $videoId)),
            ),
        ];

        return [
            'streams' => $streams,
            'files' => $files,
            'thumbnail' => new Thumbnail(\sprintf('%s.jpg', (new Ulid())->toBase32())),
        ];
    }

    protected function initialize(): static
    {
        return $this->instantiateWith(static function (array $attributes): Assets {
            return new Assets(
                streams: $attributes['streams'] ?? [],
                files: $attributes['files'] ?? [],
                thumbnail: $attributes['thumbnail'] ?? null,
            );
        });
    }
}
