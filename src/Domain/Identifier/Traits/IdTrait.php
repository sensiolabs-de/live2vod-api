<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Identifier\Traits;

trait IdTrait
{
    public function __toString(): string
    {
        return $this->toBase32();
    }
}
