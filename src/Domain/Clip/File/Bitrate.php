<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip\File;

use OskarStark\Enum\Trait\Comparable;

enum Bitrate: int
{
    use Comparable;

    case BITRATE_496400 = 496400;
    case BITRATE_789600 = 789600;
    case BITRATE_1639600 = 1639600;
    case BITRATE_3020800 = 3020800;
    case BITRATE_5299600 = 5299600;

    public static function lowest(): self
    {
        return self::BITRATE_496400;
    }

    public static function highest(): self
    {
        return self::BITRATE_5299600;
    }
}
