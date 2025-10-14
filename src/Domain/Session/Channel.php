<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session;

use OskarStark\Enum\Trait\ToArray;

enum Channel: string
{
    use ToArray;

    case ORF1 = 'orf1';
    case ORFKIDS = 'orfkids';
    case TEST_VOD = 'test_vod';
    public const VALUES = ['orf1', 'orfkids', 'test_vod'];

    public function label(): string
    {
        return match ($this) {
            self::ORF1 => 'ORF1',
            self::ORFKIDS => 'ORF Kids',
            self::TEST_VOD => 'Test VOD',
        };
    }
}
