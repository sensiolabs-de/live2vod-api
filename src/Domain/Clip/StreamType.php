<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

use OskarStark\Enum\Trait\Comparable;

enum StreamType: string
{
    use Comparable;

    case HLS = 'HLS';
    case HLS_DRM = 'HLS-DRM';
    case DASH = 'DASH';
    case DASH_DRM = 'DASH-DRM';
}
