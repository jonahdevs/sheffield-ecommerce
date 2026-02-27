<?php

namespace App\Enums;

enum AddonType: string
{
    case Pus           = 'pus';
    case FuelSurcharge = 'fuel_surcharge';
    case RemoteArea    = 'remote_area';

    public function label(): string
    {
        return match ($this) {
            self::Pus           => 'Pickup Station Surcharge',
            self::FuelSurcharge => 'Fuel Surcharge',
            self::RemoteArea    => 'Remote Area Fee',
        };
    }
}
