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
 * @phpstan-type MultiSelectFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     required: bool,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     options: array<int|string, string>,
 *     maxSelection: int|null,
 *     default: array<int, int|string>
 * }
 */
final class MultiSelectField implements Field
{
    /**
     * @param array<int|string, string> $options
     * @param array<int, int|string>    $default
     */
    public function __construct(
        private Name $name,
        private Label $label,
        private array $options,
        private bool $disabled = false,
        private ?int $maxSelection = null,
        private array $default = [],
        private bool $required = false,
        private ?Placeholder $placeholder = null,
        private ?Help $help = null,
    ) {
        Assert::notEmpty($options, 'Options must not be empty');

        foreach ($default as $defaultValue) {
            Assert::keyExists($options, $defaultValue, \sprintf('Default value "%s" must be part of the options', $defaultValue));
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
            options: $data['options'],
            disabled: $data['disabled'] ?? false,
            maxSelection: $data['maxSelection'] ?? null,
            default: $data['default'] ?? [],
            required: $data['required'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return MultiSelectFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::MULTISELECT->value,
            'required' => $this->required,
            'placeholder' => $this->placeholder?->toString(),
            'help' => $this->help?->toString(),
            'disabled' => $this->disabled,
            'options' => $this->options,
            'maxSelection' => $this->maxSelection,
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

    /**
     * @return array<int|string, string>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function getMaxSelection(): ?int
    {
        return $this->maxSelection;
    }

    /**
     * @return array<int, int|string>
     */
    public function getDefault(): array
    {
        return $this->default;
    }

    public function isRequired(): bool
    {
        return $this->required;
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
        return FieldType::MULTISELECT;
    }
}
