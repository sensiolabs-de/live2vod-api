<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\FileTransfer;

use SensioLabs\Live2Vod\Api\Domain\Clip\Filepath;
use SensioLabs\Live2Vod\Api\Domain\Url;
use Psr\Log\LoggerInterface;
use Safe\Exceptions\FilesystemException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Safe\fclose;
use function Safe\fflush;
use function Safe\flock;
use function Safe\fopen;
use function Safe\fwrite;
use function Safe\rename;
use function Safe\unlink;

final class HttpFileTransfer implements FileTransferInterface
{
    private const TEMP_FILE_EXTENSION = '.temp';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function transfer(Url $source, Filepath $destinationPath): FileTransferResult
    {
        self::validateDestinationDirectory($destinationPath->toString());

        try {
            $this->logger->debug('Starting file transfer', ['source_url' => $source->toString(), 'destination' => $destinationPath->toString()]);

            $this->doTransfer($source, $destinationPath->toString());

            $this->logger->debug('File transfer completed successfully', ['source_url' => $source->toString(), 'destination' => $destinationPath->toString()]);

            return FileTransferResult::success($source, new File($destinationPath->toString()));
        } catch (FilesystemException|TransportExceptionInterface $exception) {
            $this->logger->warning('File transfer failed', [
                'source_url' => $source->toString(),
                'destination' => $destinationPath->toString(),
                'exception' => $exception->getMessage(),
            ]);

            try {
                self::cleanupPartialDownload($destinationPath->toString());
            } catch (FilesystemException $exception) {
                return FileTransferResult::failure($source, $destinationPath, $exception->getMessage());
            }

            return FileTransferResult::failure($source, $destinationPath, $exception->getMessage());
        }
    }

    /**
     * @throws FilesystemException
     * @throws TransportExceptionInterface
     */
    private function doTransfer(Url $source, string $destinationPath): void
    {
        $tempPath = $destinationPath.self::TEMP_FILE_EXTENSION;

        $response = $this->httpClient->request(Request::METHOD_GET, $source->toString());

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new TransportException(\sprintf('HTTP request failed with status code %d', $response->getStatusCode()));
        }

        $fileHandle = fopen($tempPath, 'wb');
        flock($fileHandle, \LOCK_EX);

        try {
            foreach ($this->httpClient->stream($response) as $chunk) {
                $content = $chunk->getContent();
                fwrite($fileHandle, $content);
            }
        } finally {
            fflush($fileHandle);
            flock($fileHandle, \LOCK_UN);
            fclose($fileHandle);
        }

        // only move to destination if transfer succeeded
        rename($tempPath, $destinationPath);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private static function validateDestinationDirectory(string $destinationPath): void
    {
        $directory = \dirname($destinationPath);

        if (!\is_dir($directory)) {
            throw new \InvalidArgumentException(\sprintf('Destination directory does not exist: %s', $directory));
        }

        if (!\is_writable($directory)) {
            throw new \InvalidArgumentException(\sprintf('Destination directory is not writable: %s', $directory));
        }
    }

    /**
     * @throws FilesystemException
     */
    private static function cleanupPartialDownload(string $destinationPath): void
    {
        $tempPath = $destinationPath.self::TEMP_FILE_EXTENSION;

        if (file_exists($tempPath)) {
            unlink($tempPath);
        }

        if (file_exists($destinationPath)) {
            unlink($destinationPath);
        }
    }
}
