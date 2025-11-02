<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session;

use OskarStark\Enum\Trait\ToArray;

enum Channel: string
{
    use ToArray;

    case ORF1 = 'orf1';
    case ORFKIDS = 'orfkids';
    public const VALUES = ['orf1', 'orfkids'];

    public function label(): string
    {
        return match ($this) {
            self::ORF1 => 'ORF1',
            self::ORFKIDS => 'ORF Kids',
        };
    }
}
