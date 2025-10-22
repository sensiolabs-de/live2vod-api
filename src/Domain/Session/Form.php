<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session;

use SensioLabs\Live2Vod\Api\Domain\Session\Form\Exception\FieldNotFoundException;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Exception\FieldTypeMismatchException;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Fields;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\FieldType;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Name;

/**
 * @phpstan-import-type FormConfigArray from FormConfig
 *
 * @phpstan-type FieldArray array<string, mixed>
 * @phpstan-type FormArray array{config: FormConfigArray, fields: array<int, FieldArray>}
 */
final class Form
{
    public function __construct(
        private readonly Fields $fields = new Fields(),
        private readonly FormConfig $config = new FormConfig(),
    ) {
        if (null !== $this->config->getClipTitleField()) {
            $this->getField($this->config->getClipTitleField(), FieldType::STRING);
        }

        foreach ($this->config->getButtons() as $button) {
            $this->getField($button->getField(), FieldType::BOOLEAN);
        }

        foreach ($this->config->getValidations() as $validation) {
            $this->getField($validation->getField());
            $this->getField($validation->getCompareWith());
            $this->getField($validation->getErrorPath());
        }
    }

    /**
     * @param array{config?: FormConfigArray, fields?: array<int, FieldArray>} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Fields::fromArray($data['fields'] ?? []),
            FormConfig::fromArray($data['config'] ?? []),
        );
    }

    /**
     * @return FormArray
     */
    public function toArray(): array
    {
        return [
            'config' => $this->config->toArray(),
            'fields' => array_map(static fn (Field $field) => $field->toArray(), $this->fields->getAll()),
        ];
    }

    /**
     * @return array<int, Field>
     */
    public function getFields(): array
    {
        return $this->fields->getAll();
    }

    public function getConfig(): FormConfig
    {
        return $this->config;
    }

    /**
     * @param Name      $name Field name to search for
     * @param FieldType $type When null, returns the field matching the name.
     *                        When provided, validates that the field has the expected type
     *                        and throws FieldTypeMismatchException if not.
     *
     * @throws FieldNotFoundException     when field with given name is not found
     * @throws FieldTypeMismatchException when field exists but has different type than expected
     */
    public function getField(Name $name, ?FieldType $type = null): Field
    {
        return $this->fields->getField($name, $type);
    }
}
