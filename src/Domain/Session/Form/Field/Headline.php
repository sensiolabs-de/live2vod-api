<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form\Field;

use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\FieldType;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Label;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Name;

/**
 * @phpstan-type HeadlineArray array{
 *     name: string,
 *     label: string,
 *     type: string
 * }
 */
final class Headline implements Field
{
    public function __construct(
        private readonly Name $name,
        private readonly Label $label,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: new Name($data['name']),
            label: new Label($data['label']),
        );
    }

    /**
     * @return HeadlineArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::HEADLINE->value,
        ];
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getLabel(): Label
    {
        return $this->label;
    }

    public function isRequired(): bool
    {
        return false;
    }

    public function getType(): FieldType
    {
        return FieldType::HEADLINE;
    }
}
