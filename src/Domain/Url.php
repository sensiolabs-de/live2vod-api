<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain;

use SensioLabs\Live2Vod\Api\Exception\InvalidUrlException;
use OskarStark\Value\TrimmedNonEmptyString;

final class Url extends TrimmedNonEmptyString
{
    public function __construct(string $value)
    {
        parent::__construct($value);

        if (false === filter_var($this->value, \FILTER_VALIDATE_URL)) {
            throw InvalidUrlException::create($this->value);
        }
    }
}
