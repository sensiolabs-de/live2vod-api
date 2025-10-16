<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ClientInterface
{
    public function withHttpClient(HttpClientInterface $client): self;

    /**
     * @param array<mixed> $options
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface;
}
