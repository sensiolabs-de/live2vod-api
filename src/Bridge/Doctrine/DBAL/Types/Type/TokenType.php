<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Bridge\Doctrine\DBAL\Types\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\JsonType;
use SensioLabs\Live2Vod\Api\Domain\DRM\Token;

final class TokenType extends JsonType
{
    public function getName(): string
    {
        return self::class;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Token) {
            throw InvalidType::new($value, self::class, ['null', Token::class]);
        }

        return parent::convertToDatabaseValue($value->toArray(), $platform);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Token
    {
        $value = parent::convertToPHPValue($value, $platform);

        if (null === $value) {
            return null;
        }

        try {
            return Token::fromArray($value);
        } catch (\Exception $e) {
            throw ValueNotConvertible::new($value, self::class, $e->getMessage(), $e);
        }
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
