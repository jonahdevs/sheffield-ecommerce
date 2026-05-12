<?php

namespace App\Enums;

enum ProductType: string
{
    case SIMPLE = 'simple';
    case VARIABLE = 'variable';
    case GROUPED = 'grouped';
    case BUNDLE = 'bundle';

    public function label(): string
    {
        return match ($this) {
            self::SIMPLE => 'Simple Product',
            self::VARIABLE => 'Variable Product',
            self::GROUPED => 'Grouped Product',
            self::BUNDLE => 'Bundle Product',
        };
    }
}
