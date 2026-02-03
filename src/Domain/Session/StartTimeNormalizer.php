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
 * Examples:
 *   :12 → :10
 *   :23 → :20
 *   :35 → :30
 *   :47 → :40
 *   :58 → :50
 *   :00 → :00 (unchanged)
 */
final class StartTimeNormalizer
{
    /**
     * @var int
     */
    private const SEGMENT_DURATION_SECONDS = 10;

    public function normalize(\DateTimeImmutable $time): \DateTimeImmutable
    {
        $seconds = (int) $time->format('s');
        $normalizedSeconds = (int) floor($seconds / self::SEGMENT_DURATION_SECONDS) * self::SEGMENT_DURATION_SECONDS;
        $diff = $seconds - $normalizedSeconds;

        if (0 === $diff) {
            return $time;
        }

        return $time->modify(\sprintf('-%d seconds', $diff));
    }
}
