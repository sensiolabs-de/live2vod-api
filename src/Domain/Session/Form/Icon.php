<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use OskarStark\Enum\Trait\Comparable;

enum Icon: string
{
    use Comparable;

    case AD = 'AD';
    case AD_STRIKETHROUGH = 'AD_STRIKETHROUGH';
    case AVP = 'AVP';
    case AVP_STRIKETHROUGH = 'AVP_STRIKETHROUGH';
}
