<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use SensioLabs\Live2Vod\Api\Domain\Collection;

/**
 * @phpstan-import-type ActionArray from Action
 *
 * @phpstan-type ActionsArray list<ActionArray>
 *
 * @extends Collection<Action>
 */
final class Actions extends Collection
{
    /**
     * @param list<Action> $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    /**
     * @param ActionsArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            items: array_map(
                Action::fromArray(...),
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
            $this->all(),
        );
    }
}
