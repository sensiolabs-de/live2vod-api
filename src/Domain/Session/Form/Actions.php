<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

/**
 * @phpstan-import-type ActionArray from Action
 *
 * @phpstan-type ActionsArray list<ActionArray>
 */
final class Actions implements \Countable
{
    /**
     * @param list<Action> $values
     */
    public function __construct(
        private array $values = [],
    ) {
    }

    /**
     * @return list<Action>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param ActionsArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            values: array_map(
                static fn (array $action): Action => Action::fromArray($action),
                $data,
            ),
        );
    }

    /**
     * @return ActionsArray
     */
    public function toArray(): array
    {
        return array_map(
            static fn (Action $action): array => $action->toArray(),
            $this->values,
        );
    }

    public function count(): int
    {
        return \count($this->values);
    }
}
