<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory;

use SensioLabs\Live2Vod\Api\Domain\Request\CreateSessionRequest;
use SensioLabs\Live2Vod\Api\Domain\Session\Config;
use SensioLabs\Live2Vod\Api\Domain\Session\Form;
use SensioLabs\Live2Vod\Api\Domain\Url;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<CreateSessionRequest>
 */
final class CreateSessionRequestFactory extends ObjectFactory
{
    /**
     * @return class-string<CreateSessionRequest>
     */
    public static function class(): string
    {
        return CreateSessionRequest::class;
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes): CreateSessionRequest {
                return new CreateSessionRequest(
                    callbackUrl: $attributes['callbackUrl'],
                    form: $attributes['form'] ?? new Form(),
                    config: $attributes['config'] ?? new Config(),
                    metadata: $attributes['metadata'] ?? [],
                );
            });
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'callbackUrl' => new Url(self::faker()->url()),
            'form' => new Form(),
            'config' => new Config(),
            'metadata' => [
                'source' => self::faker()->randomElement(['cms', 'api', 'manual']),
                'version' => self::faker()->semver(),
                'userId' => self::faker()->uuid(),
            ],
        ];
    }
}
