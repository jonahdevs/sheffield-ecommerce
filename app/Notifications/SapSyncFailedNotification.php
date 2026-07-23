<?php

namespace App\Notifications;

use App\Models\Order;
use App\Notifications\Concerns\RespectsStaffPreferences;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SapSyncFailedNotification extends Notification
{
    use Queueable;
    use RespectsStaffPreferences;

    public function __construct(
        public readonly Order $order,
        public readonly \Throwable $exception,
    ) {}

    protected function staffGlobalKey(): ?string
    {
        return null;
    }

    protected function staffPreferenceKey(): ?string
    {
        return null;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('SAP sync failed - '.$this->order->order_number)
            ->markdown('mails.staff.sap-sync-failed', [
                'orderNumber' => $this->order->order_number,
                'customerName' => $this->order->user?->name ?? 'Guest',
                'customerEmail' => $this->order->user?->email ?? '-',
                'total' => number_format($this->order->total_cents / 100, 2).' KES',
                'errorMessage' => $this->exception->getMessage(),
                'url' => route('admin.orders.show', $this->order),
            ]);
    }
}
