<?php

namespace App\Enums;

enum LogisticsProviderStatus: string
{
    case ACTIVE    = 'active';
    case INACTIVE  = 'inactive';

        // Operational or billing issue — still referenced in historical
        // orders but unavailable at checkout.
    case Suspended = 'suspended';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE    => 'Active',
            self::INACTIVE  => 'Inactive',
            self::Suspended => 'Suspended',
        };
    }

    public function isAvailable(): bool
    {
        return $this === self::ACTIVE;
    }
}
