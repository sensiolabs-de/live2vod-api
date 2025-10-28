<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

enum StreamType: string
{
    case HLS = 'HLS';
    case HLS_DRM = 'HLS-DRM';
    case DASH = 'DASH';
    case DASH_DRM = 'DASH-DRM';
}
