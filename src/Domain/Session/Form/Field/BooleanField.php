<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form\Field;

use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\FieldType;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Help;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Label;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Name;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Placeholder;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type BooleanFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     default: bool|null,
 *     linkedField: string|null,
 *     nullable: bool,
 *     hidden: bool
 * }
 */
final readonly class BooleanField implements Field
{
    public function __construct(
        private Name $name,
        private Label $label,
        private bool $disabled = false,
        private ?bool $default = false,
        private bool $nullable = false,
        private bool $hidden = false,
        private ?Placeholder $placeholder = null,
        private ?Help $help = null,
        private ?Name $linkedField = null,
    ) {
        if (null === $default) {
            Assert::true($nullable, 'A "null" default is only allowed for nullable fields');
        }
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
            default: \array_key_exists('default', $data) ? $data['default'] : false,
            nullable: $data['nullable'] ?? false,
            hidden: $data['hidden'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
            linkedField: isset($data['linkedField']) ? new Name($data['linkedField']) : null,
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
            'linkedField' => $this->linkedField?->toString(),
            'nullable' => $this->nullable,
            'hidden' => $this->hidden,
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

    public function getDefault(): ?bool
    {
        return $this->default;
    }

    /**
     * @phpstan-assert-if-false !null $this->getDefault()
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
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

    public function getLinkedField(): ?Name
    {
        return $this->linkedField;
    }
}
