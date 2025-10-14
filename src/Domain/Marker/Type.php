<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Marker;

use OskarStark\Enum\Trait\Comparable;
use OskarStark\Enum\Trait\ToArray;

enum Type: string
{
    use Comparable;
    use ToArray;

    case POINT = 'point';
    case RANGE = 'range';
}
