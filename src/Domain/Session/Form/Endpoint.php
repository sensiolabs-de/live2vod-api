<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use OskarStark\Value\TrimmedNonEmptyString;
use Webmozart\Assert\Assert;

final class Endpoint extends TrimmedNonEmptyString
{
    public function __construct(string $value)
    {
        parent::__construct($value, 'Endpoint cannot be an empty string');

        Assert::startsWith($this->value, '/', 'Endpoint must start with a slash, got "%s".');
    }
}
