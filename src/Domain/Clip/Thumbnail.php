<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

use OskarStark\Value\TrimmedNonEmptyString;

final class Thumbnail
{
    /**
     * @param non-empty-string $filename
     */
    public function __construct(
        private string $filename,
    ) {
        TrimmedNonEmptyString::fromString($filename);
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function toString(): string
    {
        return $this->filename;
    }
}
