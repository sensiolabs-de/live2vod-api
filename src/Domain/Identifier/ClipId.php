<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Identifier;

use SensioLabs\Live2Vod\Api\Domain\Identifier\Traits\IdTrait;
use Symfony\Component\Uid\Ulid;

final class ClipId extends Ulid
{
    use IdTrait;
}
