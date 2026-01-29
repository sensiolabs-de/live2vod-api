<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use SensioLabs\Live2Vod\Api\Domain\Collection;

/**
 * @phpstan-import-type ButtonArray from Button
 *
 * @phpstan-type ButtonsArray list<ButtonArray>
 *
 * @extends Collection<Button>
 */
final class Buttons extends Collection
{
    /**
     * @param list<Button> $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    /**
     * @param ButtonsArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            items: array_map(
                Button::fromArray(...),
                $data,
            ),
        );
    }

    /**
     * @return ButtonsArray
     */
    public function toArray(): array
    {
        return array_map(
            static fn (Button $button): array => $button->toArray(),
            $this->all(),
        );
    }
}
