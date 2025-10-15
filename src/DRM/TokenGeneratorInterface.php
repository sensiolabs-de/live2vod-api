<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\DRM;

use SensioLabs\Live2Vod\Api\Domain\DRM\GeoLocation;
use SensioLabs\Live2Vod\Api\Domain\DRM\Token;

interface TokenGeneratorInterface
{
    /**
     * Generates a DRM token for content access control.
     *
     * @param string             $acl         Access Control List path (e.g., /orf/orf1/drmqxa-247)
     * @param GeoLocation        $geoLocation Geographic restriction
     * @param \DateTimeInterface $beginRec    Recording start time
     * @param \DateTimeInterface $endRec      Recording end time
     */
    public function generate(
        string $acl,
        GeoLocation $geoLocation,
        \DateTimeInterface $beginRec,
        \DateTimeInterface $endRec,
    ): Token;
}
