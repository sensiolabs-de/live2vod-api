<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\DRM;

use OskarStark\Enum\Trait\Comparable;

enum GeoLocation: string
{
    use Comparable;

    case WorldWide = 'g.ww';
    case Austria = 'g.at';
}
