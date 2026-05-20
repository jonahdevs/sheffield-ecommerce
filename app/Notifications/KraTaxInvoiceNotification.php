<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class KraTaxInvoiceNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Order $order,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order->loadMissing([
            'items.product',
            'payment',
            'user',
        ]);

        $mail = (new MailMessage)
            ->subject("Your KRA Tax Invoice — {$order->reference}")
            ->view('mails.orders.kra-invoice', [
                'order' => $order,
                'customerName' => $order->user?->name ?? 'Customer',
                'orderUrl' => route('customer.orders.show', $order),
            ]);

        if ($order->invoice_path && Storage::disk('local')->exists($order->invoice_path)) {
            $mail->attach(
                Storage::disk('local')->path($order->invoice_path),
                ['as' => "Invoice-{$order->reference}.pdf", 'mime' => 'application/pdf']
            );
        }

        return $mail;
    }
}
