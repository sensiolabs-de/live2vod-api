<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Download;

use SensioLabs\Live2Vod\Api\Domain\Url;
use Symfony\Component\HttpFoundation\File\File;
use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\unlink;

final class FileDownloader implements FileDownloaderInterface
{
    /**
     * @var list<string>
     */
    private array $temporaryFiles = [];

    public function __destruct()
    {
        foreach ($this->temporaryFiles as $file) {
            if (\file_exists($file)) {
                unlink($file);
            }
        }
    }

    public function download(Url $url): File
    {
        $filePath = \sprintf('%s/%s', \sys_get_temp_dir(), \basename($url->toString()));
        file_put_contents($filePath, file_get_contents($url->toString()));

        $this->temporaryFiles[] = $filePath;

        return new File($filePath);
    }
}
