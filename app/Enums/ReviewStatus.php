<?php

namespace App\Enums;

enum ReviewStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case FLAGGED = 'flagged';

    public function label()
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::FLAGGED => 'Flagged',
        };
    }

    public function color()
    {
        return match ($this) {
            self::PENDING => 'amber',     // waiting / attention
            self::APPROVED => 'green',    // success
            self::REJECTED => 'red',      // error / negative
            self::FLAGGED => 'orange',    // warning / needs review
        };
    }
}
