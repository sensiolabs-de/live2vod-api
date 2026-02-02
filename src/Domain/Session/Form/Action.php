<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

/**
 * @phpstan-type ActionArray array{field: string, endpoint: string, on: string}
 */
final class Action
{
    public function __construct(
        private readonly Name $field,
        private readonly Endpoint $endpoint,
        private readonly ActionOn $on,
    ) {
    }

    public function getField(): Name
    {
        return $this->field;
    }

    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }

    public function getOn(): ActionOn
    {
        return $this->on;
    }

    /**
     * @param ActionArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            field: new Name($data['field']),
            endpoint: new Endpoint($data['endpoint']),
            on: ActionOn::from($data['on']),
        );
    }

    /**
     * @return ActionArray
     */
    public function toArray(): array
    {
        return [
            'field' => $this->field->toString(),
            'endpoint' => $this->endpoint->toString(),
            'on' => $this->on->value,
        ];
    }
}
