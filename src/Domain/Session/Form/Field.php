<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

interface Field
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;

    public function getName(): Name;

    public function isRequired(): bool;

    public function getType(): FieldType;
}
