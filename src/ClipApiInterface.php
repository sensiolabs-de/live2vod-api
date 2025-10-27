<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;

interface ClipApiInterface
{
    public function delete(ClipId $id): void;
}
