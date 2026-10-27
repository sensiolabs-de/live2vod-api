<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\DRM;

/**
 * Access Control List (ACL) defines which paths the token grants access to.
 */
interface AclInterface extends \Stringable
{
    public function toString(): string;
}
