<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain;

/**
 * Defines the standard datetime format used across the application.
 */
final class DateTimeFormat
{
    /**
     * ISO 8601 / RFC 3339 format with UTC timezone (Z-suffix) and fixed milliseconds.
     *
     * Format: 2025-10-18T14:30:00.000Z
     *
     * This format is used for:
     * - API responses (via Context attributes)
     * - Test assertions
     * - Any datetime string representation requiring UTC
     *
     * Note: Milliseconds are always .000 since the database stores only seconds.
     */
    public const UTC_WITH_MILLISECONDS = 'Y-m-d\TH:i:s.000\Z';
}
