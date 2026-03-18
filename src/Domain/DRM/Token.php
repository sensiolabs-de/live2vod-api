<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\DRM;

use OskarStark\Value\TrimmedNonEmptyString;
use Safe\DateTimeImmutable;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type TokenArray array{value: string, expires_at: string|null, issued_at: string}
 */
final class Token
{
    public function __construct(
        private readonly string $value,
        private readonly DateTimeImmutable $issuedAt,
        private readonly ?DateTimeImmutable $expiresAt = null,
    ) {
        if ($expiresAt instanceof DateTimeImmutable) {
            Assert::greaterThan($expiresAt, $issuedAt);
        }
    }

    /**
     * @param TokenArray $data
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'value');
        Assert::keyExists($data, 'issued_at');

        TrimmedNonEmptyString::fromString($data['value']);
        TrimmedNonEmptyString::fromString($data['issued_at']);

        $expiresAt = null;

        if (isset($data['expires_at'])) {
            TrimmedNonEmptyString::fromString($data['expires_at']);
            $expiresAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['expires_at']);
        }

        return new self(
            $data['value'],
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['issued_at']),
            $expiresAt,
        );
    }

    /**
     * @return TokenArray
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'expires_at' => $this->expiresAt?->format('Y-m-d H:i:s'),
            'issued_at' => $this->issuedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function isExpired(DateTimeImmutable $at = new DateTimeImmutable()): bool
    {
        if (!$this->expiresAt instanceof DateTimeImmutable) {
            return false;
        }

        return $at > $this->expiresAt;
    }

    public function toUrlEncoded(): string
    {
        return \str_replace('%2F', '/', \rawurlencode($this->value));
    }
}
