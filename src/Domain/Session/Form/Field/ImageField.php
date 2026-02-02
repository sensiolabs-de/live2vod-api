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
 * @phpstan-type ImageFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     required: bool,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     mimeTypes: array<int, string>,
 *     maxFileSize: positive-int
 * }
 */
final class ImageField implements Field
{
    /**
     * @param array<int, string> $mimeTypes
     * @param positive-int       $maxFileSize
     */
    public function __construct(
        private readonly Name $name,
        private readonly Label $label,
        private readonly bool $disabled = false,
        private readonly array $mimeTypes = ['image/jpeg', 'image/png', 'image/webp'],
        private readonly int $maxFileSize = 10485760,
        // 10MB default
        private readonly bool $required = false,
        private readonly ?Placeholder $placeholder = null,
        private readonly ?Help $help = null,
    ) {
        Assert::notEmpty($mimeTypes, 'MIME types array cannot be empty');
        Assert::allString($mimeTypes, 'All MIME types must be strings');
        Assert::allRegex(
            $mimeTypes,
            '/^image\/[a-zA-Z0-9.\-+]+$/',
            'Invalid MIME type format. Expected format: image/type',
        );
        Assert::greaterThan($maxFileSize, 0, 'Max file size must be greater than 0');
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
            mimeTypes: $data['mimeTypes'] ?? ['image/jpeg', 'image/png', 'image/webp'],
            maxFileSize: $data['maxFileSize'] ?? 10485760,
            required: $data['required'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return ImageFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::IMAGE->value,
            'required' => $this->required,
            'placeholder' => $this->placeholder?->toString(),
            'help' => $this->help?->toString(),
            'disabled' => $this->disabled,
            'mimeTypes' => $this->mimeTypes,
            'maxFileSize' => $this->maxFileSize,
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

    /**
     * @return array<int, string>
     */
    public function getMimeTypes(): array
    {
        return $this->mimeTypes;
    }

    public function getMaxFileSize(): int
    {
        return $this->maxFileSize;
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
        return FieldType::IMAGE;
    }
}
