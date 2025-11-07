<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain;

use OskarStark\Value\TrimmedNonEmptyString;

final class Filename extends TrimmedNonEmptyString
{
    public function __construct(string $value)
    {
        parent::__construct($value, 'Filename cannot be an empty string');
    }
}
