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
 * @phpstan-type IntegerFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     required: bool,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     min: int|null,
 *     max: int|null,
 *     step: int|null,
 *     default: int|null
 * }
 */
final class IntegerField implements Field
{
    public function __construct(
        private Name $name,
        private Label $label,
        private bool $disabled = false,
        private ?int $min = null,
        private ?int $max = null,
        private ?int $step = null,
        private ?int $default = null,
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
                $remainder = $diff % $step;
                Assert::same($remainder, 0, \sprintf('Default value %s must be aligned with step %s starting from minimum %s', $default, $step, $min));
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
            min: isset($data['min']) ? (int) $data['min'] : null,
            max: isset($data['max']) ? (int) $data['max'] : null,
            step: isset($data['step']) ? (int) $data['step'] : null,
            default: isset($data['default']) ? (int) $data['default'] : null,
            required: $data['required'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return IntegerFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::INTEGER->value,
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

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function getDefault(): ?int
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
        return FieldType::INTEGER;
    }
}
