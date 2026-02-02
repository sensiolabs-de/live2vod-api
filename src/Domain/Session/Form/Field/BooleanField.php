<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form\Field;

use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\FieldType;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Help;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Label;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Name;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Placeholder;

/**
 * @phpstan-type BooleanFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     default: bool
 * }
 */
final class BooleanField implements Field
{
    public function __construct(
        private readonly Name $name,
        private readonly Label $label,
        private readonly bool $disabled = false,
        private readonly bool $default = false,
        private readonly ?Placeholder $placeholder = null,
        private readonly ?Help $help = null,
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
            disabled: $data['disabled'] ?? false,
            default: $data['default'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return BooleanFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::BOOLEAN->value,
            'placeholder' => $this->placeholder?->toString(),
            'help' => $this->help?->toString(),
            'disabled' => $this->disabled,
            'default' => $this->default,
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

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function getDefault(): bool
    {
        return $this->default;
    }

    public function isRequired(): bool
    {
        return false;
    }

    public function getPlaceholder(): ?Placeholder
    {
        return $this->placeholder;
    }

    public function getHelp(): ?Help
    {
        return $this->help;
    }

    public function getType(): FieldType
    {
        return FieldType::BOOLEAN;
    }
}
