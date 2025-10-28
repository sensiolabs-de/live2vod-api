<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\DRM;

use SensioLabs\Live2Vod\Api\Domain\DRM\Acl;
use SensioLabs\Live2Vod\Api\Domain\DRM\GeoLocation;
use SensioLabs\Live2Vod\Api\Domain\DRM\Token;
use Safe\DateTimeImmutable;
use Webmozart\Assert\Assert;
use function Safe\hex2bin;

final class TokenGenerator implements TokenGeneratorInterface
{
    public function __construct(
        private readonly string $sharedSecret,
        private readonly int $ttlInDays = 30,
    ) {
        Assert::greaterThan($ttlInDays, 0, 'TTL must be at least 1 day.');
    }

    public function generate(
        Acl $acl,
        GeoLocation $geoLocation,
        \DateTimeInterface $beginRec,
        \DateTimeInterface $endRec,
    ): Token {
        Assert::greaterThan($endRec->getTimestamp(), $beginRec->getTimestamp(), 'endRec must be greater than beginRec.');

        $issuedAt = new DateTimeImmutable();
        $expiresAt = $issuedAt->modify(\sprintf('+%d days', $this->ttlInDays));

        $beginRecFormatted = $beginRec->format('Ymd\THis');
        $endRecFormatted = $endRec->format('Ymd\THis');

        $tokenFields = [
            \sprintf('exp=%d', $expiresAt->getTimestamp()),
            \sprintf('acl=%s', $acl->toString()),
            \sprintf('geo_loc=%s', $geoLocation->value),
            \sprintf('begin_rec=%s', $beginRecFormatted),
            \sprintf('end_rec=%s', $endRecFormatted),
        ];

        // Build hash source (same as token fields for ACL-based tokens)
        $hashSource = implode('~', $tokenFields);

        $binaryKey = hex2bin($this->sharedSecret);

        $tokenFields[] = \sprintf('hmac=%s', \hash_hmac(
            'sha256',
            $hashSource,
            $binaryKey,
        ));

        return new Token(
            value: implode('~', $tokenFields),
            issuedAt: $issuedAt,
            expiresAt: $expiresAt,
        );
    }
}
