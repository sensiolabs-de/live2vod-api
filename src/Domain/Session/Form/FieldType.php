<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session\Form;

use OskarStark\Enum\Trait\Comparable;

enum FieldType: string
{
    use Comparable;

    case STRING = 'string';
    case TEXTAREA = 'textarea';
    case BOOLEAN = 'boolean';
    case INTEGER = 'integer';
    case FLOAT = 'float';
    case SELECT = 'select';
    case MULTISELECT = 'multiselect';
    case DATE = 'date';
    case DATETIME = 'datetime';
    case IMAGE = 'image';
    case URL = 'url';
}
