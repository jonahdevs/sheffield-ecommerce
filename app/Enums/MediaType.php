<?php

namespace App\Enums;

enum MediaType: string
{
    case IMAGE = 'image';
    case VIDEO_FILE = 'video_file';
    case VIDEO_EMBED = 'video_embed';

    public function label(): string
    {
        return match ($this) {
            self::IMAGE => 'Image',
            self::VIDEO_FILE => 'Uploaded video',
            self::VIDEO_EMBED => 'Video link',
        };
    }
}
