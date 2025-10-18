<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Bridge\Doctrine\DBAL\Types\Type;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\JsonType;

final class AssetsType extends JsonType
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

        if (!$value instanceof Assets) {
            throw InvalidType::new($value, self::class, ['null', Assets::class]);
        }

        return parent::convertToDatabaseValue($value->toArray(), $platform);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Assets
    {
        $value = parent::convertToPHPValue($value, $platform);

        if (null === $value) {
            return null;
        }

        try {
            return Assets::fromArray($value);
        } catch (\Exception $e) {
            throw ValueNotConvertible::new($value, self::class, $e->getMessage(), $e);
        }
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
