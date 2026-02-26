<?php

namespace App\Enums;

enum CategoryStatus: string
{
    case Draft    = 'draft';
    case Active   = 'active';
    case Inactive = 'inactive';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft    => 'Draft',
            self::Active   => 'Active',
            self::Inactive => 'Inactive',
            self::Archived => 'Archived',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft    => 'zinc',
            self::Active   => 'green',
            self::Inactive => 'yellow',
            self::Archived => 'red',
        };
    }
}
