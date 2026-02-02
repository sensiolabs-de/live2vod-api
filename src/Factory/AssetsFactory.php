<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use SensioLabs\Live2Vod\Api\Domain\Clip\File;
use SensioLabs\Live2Vod\Api\Domain\Clip\File\Bitrate;
use SensioLabs\Live2Vod\Api\Domain\Clip\Filepath;
use SensioLabs\Live2Vod\Api\Domain\Clip\Stream;
use SensioLabs\Live2Vod\Api\Domain\Clip\StreamType;
use SensioLabs\Live2Vod\Api\Domain\Url;
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
        ]);
    }

    public static function allBitrates(): self
    {
        $videoId = self::faker()->uuid();
        $baseUrl = self::faker()->url();

        $files = [];

        foreach (Bitrate::cases() as $bitrate) {
            $files[] = new File(
                filepath: new Filepath(\sprintf('videos/%s/video_%d.mp4', $videoId, $bitrate->value)),
                bitrate: $bitrate,
                url: new Url(\sprintf('%s/videos/%s/video_%d.mp4', $baseUrl, $videoId, $bitrate->value)),
            );
        }

        return self::new([
            'files' => $files,
        ]);
    }

    /**
     * @return array{streams: array<Stream>, files: array<File>}
     */
    protected function defaults(): array
    {
        $videoId = self::faker()->uuid();
        $baseUrl = self::faker()->url();

        // Only highest quality MP4 is available since ExtractOptions Profile "highest" is used
        $files = [
            new File(
                filepath: new Filepath(\sprintf('videos/%s/video_5299600.mp4', $videoId)),
                bitrate: Bitrate::highest(),
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
        ];
    }

    protected function initialize(): static
    {
        return $this->instantiateWith(static fn (array $attributes): Assets => new Assets(
            streams: $attributes['streams'] ?? [],
            files: $attributes['files'] ?? [],
        ));
    }
}
