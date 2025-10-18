<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Download;

use SensioLabs\Live2Vod\Api\Domain\Url;
use Symfony\Component\HttpFoundation\File\File;

interface FileDownloaderInterface
{
    public function download(Url $url): File;
}
