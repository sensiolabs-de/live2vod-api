<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use OskarStark\Value\TrimmedNonEmptyString;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

final class Client implements ClientInterface
{
    private HttpClientInterface $client;

    public function __construct(
        string $baseUri,
        public readonly int $timeout = 30,
        private LoggerInterface $logger = new NullLogger(),
    ) {
        new TrimmedNonEmptyString($baseUri);
        Assert::endsWith($baseUri, '/', '$baseUri must end with a "/". Got: %s');
        Assert::startsWith($baseUri, 'https://', '$baseUri must start with "https://". Got: %s');

        $this->client = HttpClient::createForBaseUri($baseUri, [
            'timeout' => $timeout,
        ]);
    }

    public function withHttpClient(HttpClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Requests an HTTP resource.
     *
     * Responses MUST be lazy, but their status code MUST be
     * checked even if none of their public methods are called.
     *
     * Implementations are not required to support all options described above; they can also
     * support more custom options; but in any case, they MUST throw a TransportExceptionInterface
     * when an unsupported option is passed.
     *
     * @param array<mixed> $options
     *
     * @throws TransportExceptionInterface When an unsupported option is passed
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        Assert::notStartsWith($url, 'http', '$url should be relative: Got: %s');
        Assert::notStartsWith($url, '/', '$url should not start with a "/". Got: %s');

        try {
            return $this->client->request(
                $method,
                $url,
                $options,
            );
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }
}
