<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

/**
 * @phpstan-import-type ButtonArray from Button
 *
 * @phpstan-type ButtonsArray list<ButtonArray>
 */
final class Buttons implements \Countable
{
    /**
     * @param list<Button> $values
     */
    public function __construct(
        private array $values = [],
    ) {
    }

    /**
     * @return list<Button>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param ButtonsArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            values: array_map(
                static fn (array $button): Button => Button::fromArray($button),
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
            $this->values,
        );
    }

    public function count(): int
    {
        return \count($this->values);
    }
}
