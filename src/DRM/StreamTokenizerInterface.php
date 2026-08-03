<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\DRM;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use SensioLabs\Live2Vod\Api\Domain\Clip\Stream;
use SensioLabs\Live2Vod\Api\Domain\DRM\Acl;
use SensioLabs\Live2Vod\Api\Domain\DRM\GeoLocation;

interface StreamTokenizerInterface
{
    public function tokenize(Stream $stream, Acl $acl, GeoLocation $geoLocation): Stream;

    public function tokenizeAssets(Assets $assets, Acl $acl, GeoLocation $geoLocation): Assets;
}
