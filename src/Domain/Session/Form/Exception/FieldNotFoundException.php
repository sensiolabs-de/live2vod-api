<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form\Exception;

use SensioLabs\Live2Vod\Api\Domain\Session\Form\Name;

final class FieldNotFoundException extends \RuntimeException
{
    public static function forName(Name $name): self
    {
        return new self(\sprintf(
            'Field with name "%s" not found',
            $name->toString(),
        ));
    }
}
