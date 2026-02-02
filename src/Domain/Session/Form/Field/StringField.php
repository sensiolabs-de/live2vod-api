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
 * @phpstan-type StringFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     required: bool,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     minLength: int|null,
 *     maxLength: int|null,
 *     pattern: string|null,
 *     default: string|null
 * }
 */
final class StringField implements Field
{
    public function __construct(
        private readonly Name $name,
        private readonly Label $label,
        private readonly bool $disabled = false,
        private readonly ?int $minLength = null,
        private readonly ?int $maxLength = null,
        private readonly ?string $pattern = null,
        private readonly ?string $default = null,
        private readonly bool $required = false,
        private readonly ?Placeholder $placeholder = null,
        private readonly ?Help $help = null,
    ) {
        if (null !== $default && null !== $pattern) {
            Assert::regex($default, $pattern, \sprintf('Default value "%s" must match the pattern "%s"', $default, $pattern));
        }

        if ($required && null !== $minLength) {
            Assert::greaterThanEq($minLength, 1, 'When field is required and minLength is set, minLength must be at least 1');
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
            minLength: $data['minLength'] ?? null,
            maxLength: $data['maxLength'] ?? null,
            pattern: $data['pattern'] ?? null,
            default: $data['default'] ?? null,
            required: $data['required'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return StringFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::STRING->value,
            'required' => $this->required,
            'placeholder' => $this->placeholder?->toString(),
            'help' => $this->help?->toString(),
            'disabled' => $this->disabled,
            'minLength' => $this->minLength,
            'maxLength' => $this->maxLength,
            'pattern' => $this->pattern,
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

    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function getDefault(): ?string
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
        return FieldType::STRING;
    }
}
