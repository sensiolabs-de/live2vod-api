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
 * @phpstan-type DateFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     required: bool,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     minDate: string|null,
 *     maxDate: string|null,
 *     default: string|null
 * }
 */
final class DateField implements Field
{
    public function __construct(
        private readonly Name $name,
        private readonly Label $label,
        private readonly bool $disabled = false,
        private readonly ?string $minDate = null,
        private readonly ?string $maxDate = null,
        private readonly ?string $default = null,
        private readonly bool $required = false,
        private readonly ?Placeholder $placeholder = null,
        private readonly ?Help $help = null,
    ) {
        if (!\in_array(null, [$this->default, $this->minDate, $this->maxDate], true)) {
            $defaultDate = \DateTimeImmutable::createFromFormat('!Y-m-d', $this->default);
            $min = \DateTimeImmutable::createFromFormat('!Y-m-d', $this->minDate);
            $max = \DateTimeImmutable::createFromFormat('!Y-m-d', $this->maxDate);

            if (!\in_array(false, [$defaultDate, $min, $max], true)) {
                Assert::true(
                    $defaultDate >= $min && $defaultDate <= $max,
                    \sprintf(
                        'Default date "%s" must be between minDate "%s" and maxDate "%s"',
                        $this->default,
                        $this->minDate,
                        $this->maxDate,
                    ),
                );
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
            minDate: $data['minDate'] ?? null,
            maxDate: $data['maxDate'] ?? null,
            default: $data['default'] ?? null,
            required: $data['required'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return DateFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::DATE->value,
            'required' => $this->required,
            'placeholder' => $this->placeholder?->toString(),
            'help' => $this->help?->toString(),
            'disabled' => $this->disabled,
            'minDate' => $this->minDate,
            'maxDate' => $this->maxDate,
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

    public function getMinDate(): ?string
    {
        return $this->minDate;
    }

    public function getMaxDate(): ?string
    {
        return $this->maxDate;
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
        return FieldType::DATE;
    }
}
