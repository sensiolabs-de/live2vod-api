<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain;

/**
 * @extends Collection<Filename>
 */
final class Filenames extends Collection
{
    public function __construct(Filename ...$filename)
    {
        parent::__construct(array_values($filename));
    }
}
