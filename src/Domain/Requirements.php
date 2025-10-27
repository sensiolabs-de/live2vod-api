<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain;

use Symfony\Component\Routing\Requirement\Requirement;

final class Requirements
{
    /**
     * Regular expression pattern for matching ULID-based JPG filenames.
     * Format: {ULID}.jpg
     * Reuses Symfony's UID_BASE32 pattern for ULID validation.
     */
    public const FILENAME_REGEX = Requirement::UID_BASE32.'\.jpg';
}
