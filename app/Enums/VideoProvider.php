<?php

namespace App\Enums;

enum VideoProvider: string
{
    case YOUTUBE = 'youtube';
    case VIMEO = 'vimeo';

    public function label(): string
    {
        return match ($this) {
            self::YOUTUBE => 'YouTube',
            self::VIMEO => 'Vimeo',
        };
    }
}
