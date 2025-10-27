<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SensioLabs\Live2Vod\Api\ClipApi;
use SensioLabs\Live2Vod\Api\ClientInterface;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ClipApiTest extends TestCase
{
    #[Test]
    public function delete(): void
    {
        $clipId = new ClipId('01JAXRHM7JZSP4Y4PXSACN8CPT');

        $response = $this->createMock(ResponseInterface::class);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects(self::once())
            ->method('request')
            ->with(
                method: Request::METHOD_DELETE,
                url: 'api/clips/01JAXRHM7JZSP4Y4PXSACN8CPT',
            )
            ->willReturn($response);

        $api = new ClipApi(client: $client);
        $api->delete(id: $clipId);
    }
}
