<?php

namespace App\Enums;

enum OrdersStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
    case RETURNED = 'returned';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'amber',
            self::CONFIRMED => 'blue',
            self::PROCESSING => 'purple',
            self::SHIPPED => 'indigo',
            self::DELIVERED => 'emerald',
            self::CANCELLED => 'rose',
            self::RETURNED => 'orange',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'clock',
            self::CONFIRMED => 'check-badge',
            self::PROCESSING => 'loader-circle',
            self::SHIPPED => 'truck',
            self::DELIVERED => 'package-check',
            self::CANCELLED => 'x-circle',
            self::RETURNED => 'rotate-ccw',
        };
    }

    public function canTransitionTo(self $new): bool
    {
        return in_array($new, $this->allowedTransitions());
    }

    public function allowedTransitions(): array
    {
        return match ($this) {
            self::PENDING    => [self::CONFIRMED, self::CANCELLED],
            self::CONFIRMED  => [self::PROCESSING, self::CANCELLED],
            self::PROCESSING => [self::SHIPPED, self::CANCELLED],
            self::SHIPPED    => [self::DELIVERED, self::RETURNED],
            self::DELIVERED  => [self::RETURNED],
            self::CANCELLED  => [],
            self::RETURNED   => [],
        };
    }
}
