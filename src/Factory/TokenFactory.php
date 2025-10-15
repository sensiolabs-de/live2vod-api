<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory;

use SensioLabs\Live2Vod\Api\Domain\DRM\Token;
use Safe\DateTimeImmutable;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<Token>
 */
final class TokenFactory extends ObjectFactory
{
    public static function class(): string
    {
        return Token::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'value' => 'test-token-value',
            'issuedAt' => new DateTimeImmutable('2024-01-01 10:00:00'),
            'expiresAt' => new DateTimeImmutable('2024-01-01 11:00:00'),
        ];
    }
}
