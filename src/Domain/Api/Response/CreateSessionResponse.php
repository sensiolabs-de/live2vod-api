<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Api\Response;

use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Webmozart\Assert\Assert;

final class CreateSessionResponse
{
    public function __construct(
        public SessionId $id,
    ) {
    }

    /**
     * @param array{
     *     id?: string,
     * } $values
     */
    public static function fromArray(array $values): self
    {
        Assert::keyExists($values, 'id');
        Assert::stringNotEmpty($values['id']);
        Assert::notWhitespaceOnly($values['id']);

        return new self(
            id: new SessionId($values['id']),
        );
    }
}
