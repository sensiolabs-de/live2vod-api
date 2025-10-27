<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;

final class NullClipApi implements ClipApiInterface
{
    public function delete(ClipId $id): void
    {
    }
}
