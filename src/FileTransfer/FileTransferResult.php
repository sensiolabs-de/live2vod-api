<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\FileTransfer;

use SensioLabs\Live2Vod\Api\Domain\Clip\Filepath;
use SensioLabs\Live2Vod\Api\Domain\Url;
use OskarStark\Value\TrimmedNonEmptyString;
use Symfony\Component\HttpFoundation\File\File;
use Webmozart\Assert\Assert;

final class FileTransferResult
{
    private function __construct(
        public readonly bool $successful,
        public readonly Url $source,
        public readonly Filepath $destinationPath,
        public readonly ?int $bytesTransferred = null,
        public readonly ?string $errorMessage = null,
    ) {
        if (null !== $bytesTransferred) {
            Assert::positiveInteger($bytesTransferred);
        }

        if (null !== $errorMessage) {
            TrimmedNonEmptyString::fromString($errorMessage);
        }
    }

    public static function success(Url $source, File $file): self
    {
        return new self(
            successful: true,
            source: $source,
            destinationPath: new Filepath((string) $file->getRealPath()),
            bytesTransferred: (int) $file->getSize(),
        );
    }

    public static function failure(Url $source, Filepath $destinationPath, string $errorMessage): self
    {
        return new self(
            successful: false,
            source: $source,
            destinationPath: $destinationPath,
            errorMessage: $errorMessage,
        );
    }
}
