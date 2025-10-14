<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use OskarStark\Value\TrimmedNonEmptyString;
use function Safe\preg_match;

final class Name extends TrimmedNonEmptyString
{
    public function __construct(string $value)
    {
        $trimmedValue = trim($value);

        if (1 === preg_match('/\s/', $trimmedValue)) {
            throw new \InvalidArgumentException('Field name cannot contain whitespace');
        }

        parent::__construct($value, 'Field name cannot be an empty string');
    }
}
