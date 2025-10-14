<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use OskarStark\Value\TrimmedNonEmptyString;
use Webmozart\Assert\Assert;

final class Help extends TrimmedNonEmptyString
{
    public function __construct(string $value)
    {
        parent::__construct($value, 'Help text cannot be empty');
        Assert::maxLength($this->value, 300, \sprintf('Help text cannot exceed %d characters', 300));
    }
}
