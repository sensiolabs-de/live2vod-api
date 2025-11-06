<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\DRM;

use SensioLabs\Live2Vod\Api\Domain\Session\Channel;

/**
 * Access Control List (ACL) defines which paths the token grants access to.
 *
 * Examples:
 * - Unencrypted content: /orf/orf1/qxa-l2v
 * - DRM encrypted content: /orf/orf1/drmqxa-l2v
 *
 * @see docs/Token Authentication_20251010.pdf
 */
final class Acl implements \Stringable
{
    public function __construct(
        public readonly Channel $channel,
        public readonly bool $drm,
    ) {
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return \sprintf('/orf/%s/%s*', $this->channel->value, $this->drm ? 'drmqxa-l2v' : 'qxa-l2v');
    }
}
