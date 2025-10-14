<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form\Exception;

use SensioLabs\Live2Vod\Api\Domain\Session\Form\FieldType;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Name;

final class FieldTypeMismatchException extends \RuntimeException
{
    public static function forField(Name $name, FieldType $expectedType, FieldType $actualType): self
    {
        return new self(\sprintf(
            'Field "%s" has type "%s" but expected type "%s"',
            $name->toString(),
            $actualType->value,
            $expectedType->value,
        ));
    }
}
