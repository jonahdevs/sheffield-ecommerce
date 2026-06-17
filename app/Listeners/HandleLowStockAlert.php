<?php

namespace App\Listeners;

use App\Events\LowStockDetected;
use App\Notifications\Inventory\LowStockAlert;
use App\Support\StaffRecipients;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class HandleLowStockAlert implements ShouldQueue
{
    public function handle(LowStockDetected $event): void
    {
        $recipients = StaffRecipients::for('products.view');

        if ($recipients->isEmpty()) {
            return;
        }

        Notification::send($recipients, new LowStockAlert($event->product, $event->currentQuantity));
    }
}
