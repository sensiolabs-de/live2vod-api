<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

use Webmozart\Assert\Assert;

/**
 * @implements \ArrayAccess<string, mixed>
 * @implements \Iterator<string, mixed>
 */
final class FormData implements \ArrayAccess, \Countable, \Iterator
{
    /**
     * @param array<string, mixed> $values
     */
    public function __construct(
        private array $values,
    ) {
        foreach (array_keys($values) as $key) {
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

    // Iterator implementation
    public function current(): mixed
    {
        return current($this->values);
    }

    public function key(): string
    {
        $key = key($this->values);

        if (null === $key) {
            return '';
        }

        return $key;
    }

    public function next(): void
    {
        next($this->values);
    }

    public function rewind(): void
    {
        reset($this->values);
    }

    public function valid(): bool
    {
        return null !== key($this->values);
    }

    // ArrayAccess implementation
    public function offsetExists(mixed $offset): bool
    {
        Assert::string($offset, 'Form data keys must be strings');

        return \array_key_exists($offset, $this->values);
    }

    public function offsetGet(mixed $offset): mixed
    {
        Assert::string($offset, 'Form data keys must be strings');

        return $this->values[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        Assert::string($offset, 'Form data keys must be strings');

        $this->values[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        Assert::string($offset, 'Form data keys must be strings');

        unset($this->values[$offset]);
    }

    // Countable implementation
    public function count(): int
    {
        return \count($this->values);
    }
}
