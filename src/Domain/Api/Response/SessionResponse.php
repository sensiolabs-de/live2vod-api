<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Api\Response;

use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Safe\DateTimeImmutable;
use Webmozart\Assert\Assert;

final class SessionResponse
{
    /**
     * @param array<string, mixed> $config
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        public readonly SessionId $id,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $updatedAt,
        public readonly array $config,
        public readonly array $metadata,
        public readonly string $callbackUrl,
        public readonly string $channel,
    ) {
    }

    /**
     * @param array{
     *     id?: string,
     *     createdAt?: string,
     *     updatedAt?: string,
     *     config?: array<string, mixed>,
     *     metadata?: array<string, mixed>,
     *     callbackUrl?: string,
     *     channel?: string,
     * } $values
     */
    public static function fromArray(array $values): self
    {
        Assert::keyExists($values, 'id');
        Assert::stringNotEmpty($values['id']);
        Assert::notWhitespaceOnly($values['id']);

        Assert::keyExists($values, 'createdAt');
        Assert::stringNotEmpty($values['createdAt']);
        Assert::notWhitespaceOnly($values['createdAt']);

        Assert::keyExists($values, 'updatedAt');
        Assert::stringNotEmpty($values['updatedAt']);
        Assert::notWhitespaceOnly($values['updatedAt']);

        Assert::keyExists($values, 'config');
        Assert::isArray($values['config']);

        Assert::keyExists($values, 'metadata');
        Assert::isArray($values['metadata']);

        Assert::keyExists($values, 'callbackUrl');
        Assert::stringNotEmpty($values['callbackUrl']);
        Assert::notWhitespaceOnly($values['callbackUrl']);
        Assert::startsWith($values['callbackUrl'], 'https://');

        Assert::keyExists($values, 'channel');
        Assert::stringNotEmpty($values['channel']);
        Assert::notWhitespaceOnly($values['channel']);

        return new self(
            id: new SessionId($values['id']),
            createdAt: new DateTimeImmutable($values['createdAt']),
            updatedAt: new DateTimeImmutable($values['updatedAt']),
            config: $values['config'],
            metadata: $values['metadata'],
            callbackUrl: $values['callbackUrl'],
            channel: $values['channel'],
        );
    }
}
