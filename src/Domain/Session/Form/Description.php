<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use OskarStark\Value\TrimmedNonEmptyString;
use Webmozart\Assert\Assert;

final class Description extends TrimmedNonEmptyString
{
    public function __construct(string $value)
    {
        parent::__construct($value, 'Description cannot be empty');
        Assert::maxLength($this->value, 300, \sprintf('Description cannot exceed %d characters', 300));
    }
}
