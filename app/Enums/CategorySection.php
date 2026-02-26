<?php

namespace App\Enums;

enum CategorySection: string
{
    case Navbar           = 'navbar';
    case HomepageFeatured = 'homepage_featured';
    case HomepageTop      = 'homepage_top';
    case Sidebar          = 'sidebar';
    case Footer           = 'footer';

    public function label(): string
    {
        return match ($this) {
            self::Navbar           => 'Navigation Bar',
            self::HomepageFeatured => 'Homepage Featured',
            self::HomepageTop      => 'Homepage Top Categories',
            self::Sidebar          => 'Sidebar',
            self::Footer           => 'Footer',
        };
    }
}
