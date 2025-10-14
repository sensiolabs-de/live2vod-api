<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip\File;

use OskarStark\Enum\Trait\Comparable;

enum Bitrate: int
{
    use Comparable;

    case BITRATE_457600 = 457600;
    case BITRATE_982400 = 982400;
    case BITRATE_1927600 = 1927600;
    case BITRATE_3120000 = 3120000;
    case BITRATE_3960000 = 3960000;
    case BITRATE_6480000 = 6480000;

    public static function lowest(): self
    {
        return self::BITRATE_457600;
    }
}
