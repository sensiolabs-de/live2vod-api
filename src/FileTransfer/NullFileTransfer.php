<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\FileTransfer;

use SensioLabs\Live2Vod\Api\Domain\Clip\Filepath;
use SensioLabs\Live2Vod\Api\Domain\Url;
use Symfony\Component\HttpFoundation\File\File;

final class NullFileTransfer implements FileTransferInterface
{
    public function __construct(
        public bool $successful,
    ) {
    }

    public function transfer(Url $source, Filepath $destinationPath): FileTransferResult
    {
        if ($this->successful) {
            return FileTransferResult::success($source, new File($destinationPath->toString()));
        }

        return FileTransferResult::failure($source, $destinationPath, 'Something went wrong.');
    }
}
