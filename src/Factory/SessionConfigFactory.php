<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory;

use SensioLabs\Live2Vod\Api\Domain\Session\Channel;
use SensioLabs\Live2Vod\Api\Domain\Session\Config;
use Safe\DateTimeImmutable;
use Zenstruck\Foundry\ObjectFactory;

/**
 * @extends ObjectFactory<Config>
 */
final class SessionConfigFactory extends ObjectFactory
{
    /**
     * @return class-string<Config>
     */
    public static function class(): string
    {
        return Config::class;
    }

    public static function empty(): Config
    {
        return self::createOne([
            'channel' => null,
            'startTime' => null,
            'endTime' => null,
            'maxClips' => null,
            'title' => null,
            'cmsUrl' => null,
        ]);
    }

    protected function initialize(): static
    {
        return $this
            ->instantiateWith(static function (array $attributes) {
                // Convert DateTimeImmutable objects to strings for fromArray
                if (isset($attributes['startTime']) && $attributes['startTime'] instanceof \DateTimeInterface) {
                    $attributes['startTime'] = $attributes['startTime']->format(\DateTimeInterface::ATOM);
                }

                if (isset($attributes['endTime']) && $attributes['endTime'] instanceof \DateTimeInterface) {
                    $attributes['endTime'] = $attributes['endTime']->format(\DateTimeInterface::ATOM);
                }

                return Config::fromArray($attributes);
            });
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        $startTime = DateTimeImmutable::createFromMutable(
            self::faker()->dateTimeBetween('-1 month', 'now'),
        );

        $endTime = DateTimeImmutable::createFromMutable(
            self::faker()->dateTimeBetween($startTime->format('Y-m-d H:i:s'), '+4 hours'),
        );

        return [
            'channel' => self::faker()->randomElement(Channel::toArray()),
            'startTime' => $startTime->format(\DateTimeInterface::ATOM),
            'endTime' => $endTime->format(\DateTimeInterface::ATOM),
            'maxClips' => self::faker()->numberBetween(1, 20),
            'title' => self::faker()->sentence(3),
            'cmsUrl' => self::faker()->url(),
        ];
    }
}
