<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain;

/**
 * @template T
 *
 * @implements \ArrayAccess<int, T>
 * @implements \IteratorAggregate<int, T>
 */
abstract class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @param list<T> $items
     */
    public function __construct(
        private array $items = [],
    ) {
    }

    /**
     * @return list<T>
     */
    public function all(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * @return \Traversable<int, T>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \BadMethodCallException('Collection is immutable');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \BadMethodCallException('Collection is immutable');
    }

    public function isEmpty(): bool
    {
        return [] === $this->items;
    }
}
