<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Api\Request;

use SensioLabs\Live2Vod\Api\Domain\Session\Config;
use SensioLabs\Live2Vod\Api\Domain\Session\Form;
use SensioLabs\Live2Vod\Api\Domain\Url;

/**
 * @phpstan-import-type ConfigArray from Config
 * @phpstan-import-type FormArray from Form
 *
 * @phpstan-type CreateSessionPayload array{
 *     callbackUrl: string,
 *     form: FormArray,
 *     config: ConfigArray,
 *     metadata: array<string, string|int|bool|float|null>,
 * }
 */
final class CreateSessionRequest implements \JsonSerializable
{
    /**
     * @param array<string, null|bool|float|int|string> $metadata
     */
    public function __construct(
        public Url $callbackUrl,
        public Form $form,
        public Config $config,
        public array $metadata = [],
    ) {
    }

    /**
     * @return CreateSessionPayload
     */
    public function toArray(): array
    {
        return [
            'callbackUrl' => $this->callbackUrl->toString(),
            'form' => $this->form->toArray(),
            'config' => $this->config->toArray(),
            'metadata' => $this->metadata,
        ];
    }

    /**
     * @return CreateSessionPayload
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
