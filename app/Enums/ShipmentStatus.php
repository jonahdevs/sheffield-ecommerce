<?php

namespace App\Enums;

enum ShipmentStatus: string
{
    /** Shipment created; awaiting courier collection. */
    case PENDING = 'pending';

    /** Courier has collected the package from the warehouse. */
    case PICKED_UP = 'picked_up';

    /** Package is moving between depots or hubs. */
    case IN_TRANSIT = 'in_transit';

    /** Package is on the last-mile delivery van, due today. */
    case OUT_FOR_DELIVERY = 'out_for_delivery';

    /** Successfully received by the customer. */
    case DELIVERED = 'delivered';

    /** Delivery attempt failed (nobody home, wrong address, etc.). */
    case FAILED = 'failed';

    /** Package rejected or undeliverable and sent back to sender. */
    case RETURNED = 'returned';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PICKED_UP => 'Picked up',
            self::IN_TRANSIT => 'In transit',
            self::OUT_FOR_DELIVERY => 'Out for delivery',
            self::DELIVERED => 'Delivered',
            self::FAILED => 'Failed',
            self::RETURNED => 'Returned',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'zinc',
            self::PICKED_UP => 'purple',
            self::IN_TRANSIT => 'yellow',
            self::OUT_FOR_DELIVERY => 'orange',
            self::DELIVERED => 'green',
            self::FAILED => 'red',
            self::RETURNED => 'red',
        };
    }

    public function isTerminal(): bool
    {
        return in_array($this, [self::DELIVERED, self::FAILED, self::RETURNED]);
    }
}
