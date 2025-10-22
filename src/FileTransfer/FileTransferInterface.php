<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\FileTransfer;

use SensioLabs\Live2Vod\Api\Domain\Clip\Filepath;
use SensioLabs\Live2Vod\Api\Domain\Url;

interface FileTransferInterface
{
    public function transfer(Url $source, Filepath $destinationPath): FileTransferResult;
}
