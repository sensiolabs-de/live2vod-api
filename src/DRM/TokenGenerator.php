<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\DRM;

use SensioLabs\Live2Vod\Api\Domain\DRM\Acl;
use SensioLabs\Live2Vod\Api\Domain\DRM\AclInterface;
use SensioLabs\Live2Vod\Api\Domain\DRM\GeoLocation;
use SensioLabs\Live2Vod\Api\Domain\DRM\Token;
use Safe\DateTimeImmutable;
use Webmozart\Assert\Assert;
use function Safe\hex2bin;

final readonly class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * Basic ISO 8601 format with millisecond precision, e.g. "20260728T102700.000Z".
     *
     * The frame-accurate ORS API requires `begin_rec` and `end_rec` with exactly
     * three millisecond digits - trailing zeros must not be removed.
     */
    private const string DATE_FORMAT = 'Ymd\THis.v\Z';

    public function __construct(
        private string $sharedSecret,
        private ?int $ttlInDays = null,
    ) {
        if (null !== $ttlInDays) {
            Assert::greaterThan($ttlInDays, 0, 'TTL must be at least 1 day.');
        }
    }

    public function generate(
        Acl $acl,
        GeoLocation $geoLocation,
        \DateTimeInterface $beginRec,
        \DateTimeInterface $endRec,
    ): Token {
        Assert::greaterThan($endRec->getTimestamp(), $beginRec->getTimestamp(), 'endRec must be greater than beginRec.');

        // The "Z" designator is part of the format, so make sure the dates are UTC
        $utc = new \DateTimeZone('UTC');

        return $this->sign([
            \sprintf('acl=%s', $acl->toString()),
            \sprintf('geo_loc=%s', $geoLocation->value),
            \sprintf('begin_rec=%s', DateTimeImmutable::createFromInterface($beginRec)->setTimezone($utc)->format(self::DATE_FORMAT)),
            \sprintf('end_rec=%s', DateTimeImmutable::createFromInterface($endRec)->setTimezone($utc)->format(self::DATE_FORMAT)),
        ]);
    }

    public function generateForVod(AclInterface $acl, GeoLocation $geoLocation): Token
    {
        return $this->sign([
            \sprintf('acl=%s', $acl->toString()),
            \sprintf('geo_loc=%s', $geoLocation->value),
        ]);
    }

    /**
     * Prepends "exp" if a TTL is configured and appends the "hmac" of all fields.
     *
     * @param list<string> $fields
     */
    private function sign(array $fields): Token
    {
        $issuedAt = new DateTimeImmutable();
        $expiresAt = null;
        $tokenFields = [];

        if (null !== $this->ttlInDays) {
            $expiresAt = $issuedAt->modify(\sprintf('+%d days', $this->ttlInDays));
            $tokenFields[] = \sprintf('exp=%d', $expiresAt->getTimestamp());
        }

        $tokenFields = [...$tokenFields, ...$fields];

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
