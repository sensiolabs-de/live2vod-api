<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Download;

use SensioLabs\Live2Vod\Api\Domain\Url;
use Symfony\Component\HttpFoundation\File\File;

final class NullFileDownloader implements FileDownloaderInterface
{
    public function __construct(
        private string $filepath,
    ) {
    }

    public function download(Url $url): File
    {
        return new File($this->filepath);
    }
}
