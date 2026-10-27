<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip\Exception;

use SensioLabs\Live2Vod\Api\Domain\Clip\StreamType;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class StreamNotFoundException extends NotFoundHttpException
{
    public static function forType(StreamType $type, ?ClipId $clipId = null): self
    {
        return new self(\sprintf('Stream with type "%s" not found%s', $type->value, self::forClip($clipId)));
    }

    public static function noStreams(?ClipId $clipId = null): self
    {
        return new self(\sprintf('No streams found%s', self::forClip($clipId)));
    }

    private static function forClip(?ClipId $clipId): string
    {
        return $clipId instanceof ClipId ? \sprintf(' for clip "%s"', (string) $clipId) : '';
    }
}
