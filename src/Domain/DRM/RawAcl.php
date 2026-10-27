<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\DRM;

use Webmozart\Assert\Assert;

/**
 * ACL for paths that are not derived from a channel, e.g. VOD content.
 *
 * Examples:
 * - Unencrypted VOD content: /orf-vod/vod/qxa*
 * - DRM encrypted VOD content: /orf-vod/vod/drmqxa*
 *
 * @see docs/Token Authentication_20251010.pdf
 */
final readonly class RawAcl implements \Stringable, AclInterface
{
    public function __construct(public string $value)
    {
        Assert::startsWith($value, '/', 'ACL must start with "/". Got: %s');
        Assert::endsWith($value, '*', 'ACL must end with "*". Got: %s');
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
