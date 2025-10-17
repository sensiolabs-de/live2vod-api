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
 * @phpstan-type FloatFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     required: bool,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     min: float|null,
 *     max: float|null,
 *     step: float|null,
 *     default: float|null
 * }
 */
final class FloatField implements Field
{
    public function __construct(
        private Name $name,
        private Label $label,
        private bool $disabled = false,
        private ?float $min = null,
        private ?float $max = null,
        private ?float $step = null,
        private ?float $default = null,
        private bool $required = false,
        private ?Placeholder $placeholder = null,
        private ?Help $help = null,
    ) {
        if (null !== $step) {
            Assert::greaterThan($step, 0, 'Step value must be greater than 0');
        }

        if (null !== $default) {
            if (null !== $min) {
                Assert::greaterThanEq($default, $min, \sprintf('Default value %s must be greater than or equal to minimum %s', $default, $min));
            }

            if (null !== $max) {
                Assert::lessThanEq($default, $max, \sprintf('Default value %s must be less than or equal to maximum %s', $default, $max));
            }

            if (null !== $step && null !== $min) {
                $diff = $default - $min;
                $remainder = fmod($diff, $step);
                // Allow for floating point precision issues
                Assert::true(abs($remainder) < 0.0000001 || abs($remainder - $step) < 0.0000001, \sprintf('Default value %s must be aligned with step %s starting from minimum %s', $default, $step, $min));
            }
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
            min: isset($data['min']) ? (float) $data['min'] : null,
            max: isset($data['max']) ? (float) $data['max'] : null,
            step: isset($data['step']) ? (float) $data['step'] : null,
            default: isset($data['default']) ? (float) $data['default'] : null,
            required: $data['required'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return FloatFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::FLOAT->value,
            'required' => $this->required,
            'placeholder' => $this->placeholder?->toString(),
            'help' => $this->help?->toString(),
            'disabled' => $this->disabled,
            'min' => $this->min,
            'max' => $this->max,
            'step' => $this->step,
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

    public function getMin(): ?float
    {
        return $this->min;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }

    public function getStep(): ?float
    {
        return $this->step;
    }

    public function getDefault(): ?float
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
        return FieldType::FLOAT;
    }
}
