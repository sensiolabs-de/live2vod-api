<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\DRM;

use SensioLabs\Live2Vod\Api\Domain\DRM\Acl;
use SensioLabs\Live2Vod\Api\Domain\DRM\AclInterface;
use SensioLabs\Live2Vod\Api\Domain\DRM\GeoLocation;
use SensioLabs\Live2Vod\Api\Domain\DRM\Token;

interface TokenGeneratorInterface
{
    /**
     * Generates a DRM token for content access control.
     *
     * @param Acl                $acl         Access Control List defining which paths the token grants access to
     * @param GeoLocation        $geoLocation Geographic restriction
     * @param \DateTimeInterface $beginRec    Recording start time
     * @param \DateTimeInterface $endRec      Recording end time
     */
    public function generate(
        Acl $acl,
        GeoLocation $geoLocation,
        \DateTimeInterface $beginRec,
        \DateTimeInterface $endRec,
    ): Token;

    /**
     * Generates a token for VOD content: only acl, geo_loc and hmac (plus exp if a TTL is configured).
     *
     * VOD URLs have no recording window, so begin_rec/end_rec are not part of the token.
     *
     * @param AclInterface $acl         Access Control List defining which paths the token grants access to
     * @param GeoLocation  $geoLocation Geographic restriction
     */
    public function generateForVod(AclInterface $acl, GeoLocation $geoLocation): Token;
}
