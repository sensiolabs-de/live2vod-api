<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use SensioLabs\Live2Vod\Api\Domain\Collection;

/**
 * @phpstan-import-type ValidationArray from Validation
 *
 * @phpstan-type ValidationsArray list<ValidationArray>
 *
 * @extends Collection<Validation>
 */
final class Validations extends Collection
{
    /**
     * @param list<Validation> $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    /**
     * @param ValidationsArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            items: array_map(
                static fn (array $validation): Validation => Validation::fromArray($validation),
                $data,
            ),
        );
    }

    /**
     * @return ValidationsArray
     */
    public function toArray(): array
    {
        return array_map(
            static fn (Validation $validation): array => $validation->toArray(),
            $this->all(),
        );
    }
}
