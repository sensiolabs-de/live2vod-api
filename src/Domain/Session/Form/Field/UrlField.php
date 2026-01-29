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
use function Safe\parse_url;

/**
 * @phpstan-type UrlFieldArray array{
 *     name: string,
 *     label: string,
 *     type: string,
 *     required: bool,
 *     placeholder: string|null,
 *     help: string|null,
 *     disabled: bool,
 *     default: string|null,
 *     protocols: array<int, string>
 * }
 */
final class UrlField implements Field
{
    /**
     * @param array<int, string> $protocols
     */
    public function __construct(
        private Name $name,
        private Label $label,
        private bool $disabled = false,
        private ?string $default = null,
        private array $protocols = ['http', 'https'],
        private bool $required = false,
        private ?Placeholder $placeholder = null,
        private ?Help $help = null,
    ) {
        Assert::notEmpty($protocols, 'Protocols array cannot be empty');
        Assert::allString($protocols, 'All protocols must be strings');
        Assert::allRegex(
            $protocols,
            '/^[a-zA-Z][a-zA-Z0-9+.-]*$/',
            'Invalid protocol format. Protocols must start with a letter and contain only letters, numbers, +, -, or .',
        );

        if (null !== $this->default) {
            try {
                $parsedUrl = parse_url($this->default);
            } catch (\Exception) {
                throw new \InvalidArgumentException(\sprintf('Invalid URL format: "%s"', $this->default));
            }

            if (!\is_array($parsedUrl) || !isset($parsedUrl['scheme'])) {
                throw new \InvalidArgumentException(\sprintf('Invalid URL format: "%s"', $this->default));
            }

            Assert::inArray(
                $parsedUrl['scheme'],
                $this->protocols,
                \sprintf(
                    'URL protocol "%s" is not allowed. Allowed protocols: %s',
                    $parsedUrl['scheme'],
                    implode(', ', $this->protocols),
                ),
            );
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
            default: $data['default'] ?? null,
            protocols: $data['protocols'] ?? ['http', 'https'],
            required: $data['required'] ?? false,
            placeholder: isset($data['placeholder']) ? new Placeholder($data['placeholder']) : null,
            help: isset($data['help']) ? new Help($data['help']) : null,
        );
    }

    /**
     * @return UrlFieldArray
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name->toString(),
            'label' => $this->label->toString(),
            'type' => FieldType::URL->value,
            'required' => $this->required,
            'placeholder' => $this->placeholder?->toString(),
            'help' => $this->help?->toString(),
            'disabled' => $this->disabled,
            'default' => $this->default,
            'protocols' => $this->protocols,
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

    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @return array<int, string>
     */
    public function getProtocols(): array
    {
        return $this->protocols;
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
        return FieldType::URL;
    }
}
