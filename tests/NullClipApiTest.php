<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Tests;

use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use SensioLabs\Live2Vod\Api\NullClipApi;

final class NullClipApiTest extends TestCase
{
    #[Test]
    #[DoesNotPerformAssertions]
    public function itDeletesClipWithoutError(): void
    {
        $api = new NullClipApi();
        $clipId = new ClipId();

        $api->delete($clipId);
    }
}
