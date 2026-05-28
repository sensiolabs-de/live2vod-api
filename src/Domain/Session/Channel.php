<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session;

use OskarStark\Enum\Trait\ToArray;

enum Channel: string
{
    use ToArray;

    case ORF1 = 'orf1';
    case ORFKIDS = 'orfkids';
    case ORF2W = 'orf2w';
    public const VALUES = ['orf1', 'orfkids', 'orf2w'];

    public function label(): string
    {
        return match ($this) {
            self::ORF1 => 'ORF1',
            self::ORFKIDS => 'ORF Kids',
            self::ORF2W => 'ORF2 Wien',
        };
    }

    public function toAclString(): string
    {
        return match ($this) {
            self::ORFKIDS => 'orfk',
            default => $this->value,
        };
    }
}
