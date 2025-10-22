<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

/**
 * @phpstan-type ValidationArray array{field: string, comparator: string, compareWith: string, errorPath: string}
 */
final class Validation
{
    public function __construct(
        private Name $field,
        private Comparator $comparator,
        private Name $compareWith,
        private Name $errorPath,
    ) {
        if ($field->equals($compareWith)) {
            throw new \InvalidArgumentException('Field and compareWith cannot be the same');
        }

        if (!$errorPath->equals($field) && !$errorPath->equals($compareWith)) {
            throw new \InvalidArgumentException('ErrorPath must be either field or compareWith');
        }
    }

    public function getField(): Name
    {
        return $this->field;
    }

    public function getComparator(): Comparator
    {
        return $this->comparator;
    }

    public function getCompareWith(): Name
    {
        return $this->compareWith;
    }

    public function getErrorPath(): Name
    {
        return $this->errorPath;
    }

    /**
     * @param ValidationArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            field: new Name($data['field']),
            comparator: Comparator::from($data['comparator']),
            compareWith: new Name($data['compareWith']),
            errorPath: new Name($data['errorPath']),
        );
    }

    /**
     * @return ValidationArray
     */
    public function toArray(): array
    {
        return [
            'field' => $this->field->toString(),
            'comparator' => $this->comparator->value,
            'compareWith' => $this->compareWith->toString(),
            'errorPath' => $this->errorPath->toString(),
        ];
    }
}
