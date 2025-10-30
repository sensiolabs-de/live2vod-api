<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Webhook;

enum Event: string
{
    case CLIP_COMPLETED = 'clip_completed';
    case CLIP_CREATED = 'clip_created';
    case CLIP_DELETED = 'clip_deleted';
    case CLIP_ERROR = 'clip_error';
    case CLIP_UPDATED = 'clip_updated';
    case CLIPS_COMPLETED = 'clips_completed';
    case CLIPS_FAILED = 'clips_failed';
    case SESSION_DELETED = 'session_deleted';
}
