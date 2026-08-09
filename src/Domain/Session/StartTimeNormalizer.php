<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session;

/**
 * Normalizes start times to 10-second segment boundaries.
 *
 * ORS/Broadpeak manifests are aligned to 10-second segment boundaries.
 * When a user selects an arbitrary time (e.g., 08:45:12), we normalize
 * it to the nearest 10-second boundary by rounding down (e.g., 08:45:10).
 *
 * This ensures consistent timeline alignment and prevents the UI from
 * showing content that starts after the user's selection.
 *
 * Milliseconds are dropped as well, since a segment boundary is always a whole second.
 * Clip boundaries (markIn/markOut) keep their millisecond precision - only the preview
 * window of a session is snapped to a segment.
 *
 * Examples:
 *   :12.345 → :10.000
 *   :23     → :20
 *   :35     → :30
 *   :47     → :40
 *   :58     → :50
 *   :00     → :00 (unchanged)
 */
final class StartTimeNormalizer
{
    private const int SEGMENT_DURATION_SECONDS = 10;

    public function normalize(\DateTimeImmutable $time): \DateTimeImmutable
    {
        return $time->setTime(
            (int) $time->format('G'),
            (int) $time->format('i'),
            intdiv((int) $time->format('s'), self::SEGMENT_DURATION_SECONDS) * self::SEGMENT_DURATION_SECONDS,
        );
    }
}
