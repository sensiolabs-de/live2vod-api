<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Clip;

use SensioLabs\Live2Vod\Api\Domain\Url;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type StreamArray array{type: string, url: string}
 */
final class Stream
{
    public function __construct(
        private StreamType $type,
        private Url $url,
    ) {
    }

    public function getType(): StreamType
    {
        return $this->type;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @return StreamArray
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'url' => $this->url->toString(),
        ];
    }

    /**
     * @param StreamArray $data
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'type');
        Assert::string($data['type']);
        Assert::keyExists($data, 'url');
        Assert::string($data['url']);

        return new self(
            type: StreamType::from($data['type']),
            url: new Url($data['url']),
        );
    }
}
