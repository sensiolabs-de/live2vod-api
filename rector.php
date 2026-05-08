<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

/**
 * Rector configuration for PHP 8.3 compatibility.
 *
 * This config downgrades PHP 8.4+ syntax to PHP 8.3 compatible code.
 *
 * Run with: vendor/bin/rector process live2vod-api/src --config live2vod-api/rector.php
 */
return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
    ])
    ->withDowngradeSets(php83: true)
    ->withImportNames(importShortClasses: false);
