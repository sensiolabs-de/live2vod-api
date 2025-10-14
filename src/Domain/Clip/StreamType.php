<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

enum StreamType: string
{
    case HLS = 'HLS';
    case HLS_247 = 'HLS-247';
    case HLS_DRM = 'HLS-DRM';
    case HLS_DRM_247 = 'HLS-247-DRM';
    case DASH = 'DASH';
    case DASH_247 = 'DASH-247';
    case DASH_DRM = 'DASH-DRM';
    case DASH_DRM_247 = 'DASH-247-DRM';
}
