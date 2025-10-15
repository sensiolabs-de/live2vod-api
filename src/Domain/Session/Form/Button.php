<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

/**
 * @phpstan-type ButtonArray array{field: string, icons: array{true: string, false: string}}
 */
final class Button
{
    public function __construct(
        private Name $field,
        private Icon $iconWhenTrue,
        private Icon $iconWhenFalse,
    ) {
    }

    public function getField(): Name
    {
        return $this->field;
    }

    public function getIconWhenTrue(): Icon
    {
        return $this->iconWhenTrue;
    }

    public function getIconWhenFalse(): Icon
    {
        return $this->iconWhenFalse;
    }

    /**
     * @param ButtonArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            field: new Name($data['field']),
            iconWhenTrue: Icon::from($data['icons']['true']),
            iconWhenFalse: Icon::from($data['icons']['false']),
        );
    }

    /**
     * @return ButtonArray
     */
    public function toArray(): array
    {
        return [
            'field' => $this->field->toString(),
            'icons' => [
                'true' => $this->iconWhenTrue->value,
                'false' => $this->iconWhenFalse->value,
            ],
        ];
    }
}
