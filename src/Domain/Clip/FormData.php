<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

use Webmozart\Assert\Assert;

final class FormData
{
    /**
     * @param array<string, mixed> $values
     */
    public function __construct(
        private array $values,
    ) {
        foreach ($values as $key => $value) {
            Assert::string($key, 'Form data keys must be strings');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public function get(string $key): mixed
    {
        return $this->values[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return \array_key_exists($key, $this->values);
    }

    public function isEmpty(): bool
    {
        return [] === $this->values;
    }
}
