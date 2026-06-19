<?php

namespace App\Enums;

enum CategorySection: string
{
    case NAVBAR = 'navbar';
    case HOME_PAGE_FEATURED = 'homepage_featured';
    case FOOTER = 'footer';

    public function label(): string
    {
        return match ($this) {
            self::NAVBAR => 'Navbar',
            self::HOME_PAGE_FEATURED => 'Home Page Featured',
            self::FOOTER => 'Footer',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::NAVBAR => 'Categories shown in the main navigation menu.',
            self::HOME_PAGE_FEATURED => 'Categories displayed in the "Shop by category" grid on the homepage.',
            self::FOOTER => 'Category links in the site footer.',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::NAVBAR => 'bars-3',
            self::HOME_PAGE_FEATURED => 'home',
            self::FOOTER => 'document-text',
        };
    }
}
