<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

/**
 * Rector configuration for PHP 8.1 compatibility.
 *
 * This config downgrades PHP 8.2+ and 8.3+ syntax to PHP 8.1 compatible code.
 * It handles:
 * - Typed class constants (PHP 8.3) → untyped constants
 * - Readonly classes (PHP 8.2) → regular classes
 *
 * Run with: vendor/bin/rector process live2vod-api/src --config live2vod-api/rector.php
 */
return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
    ])
    ->withDowngradeSets(php81: true)
    ->withImportNames(importShortClasses: false);
