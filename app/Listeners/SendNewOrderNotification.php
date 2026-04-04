<?php

namespace App\Listeners;

use App\Events\PaymentConfirmed;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Settings\NotificationSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendNewOrderNotification
{
    public function __construct(
        private readonly NotificationSettings $notificationSettings
    ) {}

    public function handle(PaymentConfirmed $event): void
    {
        if (! $this->notificationSettings->notify_new_order) {
            return;
        }

        try {
            // Send to all staff users so the database channel writes to their
            // notifications table (powers the admin notification dropdown).
            // Mail is still delivered to the configured admin email via toMail().
            $staffUsers = User::staff()->get();

            Notification::send($staffUsers, new NewOrderNotification($event->order));

            Log::info('New order notification sent to admin staff', [
                'order_id' => $event->order->id,
                'reference' => $event->order->reference,
                'staff_count' => $staffUsers->count(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send new order notification to admin', [
                'order_id' => $event->order->id,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
