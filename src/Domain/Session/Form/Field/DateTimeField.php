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
 * @phpstan-type DateTimeFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     required: bool,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     minDateTime: string|null,
 *     maxDateTime: string|null,
 *     default: string|null
 * }
 */
final class DateTimeField implements Field
{
    public function __construct(
        private Name $name,
        private Label $label,
        private bool $disabled = false,
        private ?string $minDateTime = null,
        private ?string $maxDateTime = null,
        private ?string $default = null,
        private bool $required = false,
        private ?Placeholder $placeholder = null,
        private ?Help $help = null,
    ) {
        if (!\in_array(null, [$this->default, $this->minDateTime, $this->maxDateTime], true)) {
            $defaultDateTime = \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $this->default);
            $min = \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $this->minDateTime);
            $max = \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $this->maxDateTime);

            if (!\in_array(false, [$defaultDateTime, $min, $max], true)) {
                Assert::true(
                    $defaultDateTime >= $min && $defaultDateTime <= $max,
                    \sprintf(
                        'Default datetime "%s" must be between minDateTime "%s" and maxDateTime "%s"',
                        $this->default,
                        $this->minDateTime,
                        $this->maxDateTime,
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
            minDateTime: $data['minDateTime'] ?? null,
            maxDateTime: $data['maxDateTime'] ?? null,
            default: $data['default'] ?? null,
            required: $data['required'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return DateTimeFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::DATETIME->value,
            'required' => $this->required,
            'placeholder' => $this->placeholder?->toString(),
            'help' => $this->help?->toString(),
            'disabled' => $this->disabled,
            'minDateTime' => $this->minDateTime,
            'maxDateTime' => $this->maxDateTime,
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

    public function getMinDateTime(): ?string
    {
        return $this->minDateTime;
    }

    public function getMaxDateTime(): ?string
    {
        return $this->maxDateTime;
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
        return FieldType::DATETIME;
    }
}
