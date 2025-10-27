<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain;

use Symfony\Component\Routing\Requirement\Requirement;

/**
 * Validation requirements and patterns used across the application.
 * This class cannot be instantiated.
 */
final class Requirements
{
    /**
     * Regular expression pattern for matching ULID-based image filenames.
     * Format: {ULID}.(jpg|jpeg|png|webp)
     * Reuses Symfony's UID_BASE32 pattern for ULID validation.
     */
    public const FILENAME_REGEX = Requirement::UID_BASE32.'\.(jpg|jpeg|png|webp)';

    /**
     * ISO 8601 datetime format regex pattern.
     * Matches formats like:
     * - 2023-12-25T10:30:00Z
     * - 2023-12-25T10:30:00+02:00
     * - 2023-12-25T10:30:00.123Z
     * - 2023-12-25T10:30:00.123+02:00.
     */
    public const ISO_8601 = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d{3})?(Z|[+-]\d{2}:\d{2})$/';

    private function __construct()
    {
        // This class cannot be instantiated
    }
}
