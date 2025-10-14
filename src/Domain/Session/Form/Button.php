<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

/**
 * @phpstan-type ButtonArray array{field: string, icon: string}
 */
final class Button
{
    public function __construct(
        private Name $field,
        private Icon $icon,
    ) {
    }

    public function getField(): Name
    {
        return $this->field;
    }

    public function getIcon(): Icon
    {
        return $this->icon;
    }

    /**
     * @param ButtonArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            field: new Name($data['field']),
            icon: Icon::from($data['icon']),
        );
    }

    /**
     * @return ButtonArray
     */
    public function toArray(): array
    {
        return [
            'field' => $this->field->toString(),
            'icon' => $this->icon->value,
        ];
    }
}
