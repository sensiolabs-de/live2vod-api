<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain;

/**
 * Defines the standard datetime format used across the application.
 */
final class DateTimeFormat
{
    /**
     * ISO 8601 / RFC 3339 format with UTC timezone (Z-suffix) and milliseconds.
     *
     * Format: 2025-10-18T14:30:00.123Z
     *
     * This format is used for:
     * - API responses (via Context attributes)
     * - Test assertions
     * - Any datetime string representation requiring UTC
     *
     * The database stores timestamps with millisecond precision using TIMESTAMP(3).
     * Microseconds are truncated to milliseconds for display (v = microseconds / 1000).
     */
    public const UTC_WITH_MILLISECONDS = 'Y-m-d\TH:i:s.v\Z';

    /**
     * ISO 8601 / RFC 3339 format with UTC timezone (Z-suffix) without milliseconds.
     *
     * Format: 2025-10-18T14:30:00Z
     *
     * This format is used for timestamps that don't require millisecond precision.
     */
    public const UTC = 'Y-m-d\TH:i:s\Z';
}
