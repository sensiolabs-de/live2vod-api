<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use SensioLabs\Live2Vod\Api\Domain\Session\Form\Exception\FieldNotFoundException;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Exception\FieldTypeMismatchException;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\BooleanField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\DateField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\DateTimeField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\ImageField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\MultiSelectField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\NumberField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\SelectField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\StringField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\TextareaField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\UrlField;
use Webmozart\Assert\Assert;

final class Fields
{
    /**
     * @var array<int, Field>
     */
    private readonly array $fields;

    public function __construct(Field ...$field)
    {
        $this->fields = array_values($field);

        // Validate unique field names
        $names = array_map(static fn (Field $field) => $field->toArray()['name'], $this->fields);
        $duplicates = array_filter(array_count_values($names), static fn (int $count) => 1 < $count);

        Assert::isEmpty(
            $duplicates,
            \sprintf(
                'Field names must be unique. Duplicate names found: %s',
                implode(', ', array_keys($duplicates)),
            ),
        );
    }

    /**
     * @param array<int, array<string, mixed>> $data
     */
    public static function fromArray(array $data): self
    {
        $fields = array_map(static fn (array $fieldData) => self::createFieldFromArray($fieldData), $data);

        return new self(...$fields);
    }

    /**
     * @return array<int, Field>
     */
    public function getAll(): array
    {
        return $this->fields;
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
        foreach ($this->fields as $field) {
            if ($field->getName()->equals($name)) {
                if (null !== $type && !$field->getType()->equals($type)) {
                    throw FieldTypeMismatchException::forField($name, $type, $field->getType());
                }

                return $field;
            }
        }

        throw FieldNotFoundException::forName($name);
    }

    /**
     * @param array<string, mixed> $data
     */
    private static function createFieldFromArray(array $data): Field
    {
        Assert::keyExists($data, 'type', 'Field data must contain a "type" key');

        $type = FieldType::from($data['type']);

        return match ($type) {
            FieldType::STRING => StringField::fromArray($data),
            FieldType::TEXTAREA => TextareaField::fromArray($data),
            FieldType::BOOLEAN => BooleanField::fromArray($data),
            FieldType::NUMBER => NumberField::fromArray($data),
            FieldType::SELECT => SelectField::fromArray($data),
            FieldType::MULTISELECT => MultiSelectField::fromArray($data),
            FieldType::DATE => DateField::fromArray($data),
            FieldType::DATETIME => DateTimeField::fromArray($data),
            FieldType::IMAGE => ImageField::fromArray($data),
            FieldType::URL => UrlField::fromArray($data),
        };
    }
}
