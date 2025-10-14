<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Exception;

final class InvalidUrlException extends \DomainException
{
    public static function create(string $value): self
    {
        return new self(\sprintf('Invalid URL: "%s".', $value));
    }
}
