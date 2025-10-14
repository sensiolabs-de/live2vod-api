<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip\Exception;

use SensioLabs\Live2Vod\Api\Domain\Clip\File\Bitrate;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class FileNotFoundException extends NotFoundHttpException
{
    public static function forBitrate(Bitrate $bitrate, ClipId $clipId): self
    {
        return new self(\sprintf('MP4 file with bitrate "%d" not found for clip "%s"', $bitrate->value, $clipId->toString()));
    }
}
