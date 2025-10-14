<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use OskarStark\Enum\Trait\Comparable;

enum Icon: string
{
    use Comparable;

    case AD = 'AD';
    case AVP = 'AVP';
}
