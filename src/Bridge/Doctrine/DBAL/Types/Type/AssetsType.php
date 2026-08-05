<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Bridge\Doctrine\DBAL\Types\Type;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;

/**
 * This class is synced to sensiolabs-de/live2vod-api, which supports `doctrine/dbal` ^3.0 and ^4.0.
 * `ConversionException` is therefore thrown directly, as the more specific `InvalidType` and
 * `ValueNotConvertible` subclasses only exist in `doctrine/dbal` ^4.0.
 */
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
            throw new ConversionException(\sprintf(
                'Could not convert PHP value of type %s to type %s. Expected one of the following types: null, %s.',
                get_debug_type($value),
                self::class,
                Assets::class,
            ));
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
            throw new ConversionException(\sprintf(
                'Could not convert database value to "%s" as an error was triggered by the unserialization: %s',
                self::class,
                $e->getMessage(),
            ), 0, $e);
        }
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
