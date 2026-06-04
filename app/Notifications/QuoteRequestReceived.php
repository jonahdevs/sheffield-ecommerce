<?php

namespace App\Notifications;

use App\Models\Quote;
use App\Models\User;
use App\Settings\BrandingSettings;
use App\Settings\QuotationSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteRequestReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Quote $quote) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $storeName = app(BrandingSettings::class)->store_name ?: config('app.name');
        $validityDays = app(QuotationSettings::class)->default_validity_days;

        return (new MailMessage)
            ->subject("Quote request received — {$this->quote->quote_number}")
            ->greeting("Hello {$this->quote->contact_name},")
            ->line("Thank you for your quote request. We've received it and our team will review it shortly.")
            ->line("**Quote number:** {$this->quote->quote_number}")
            ->line("**Items requested:** {$this->quote->items()->count()}")
            ->when($this->quote->delivery_required, fn ($m) => $m->line("**Delivery:** Required — {$this->quote->delivery_address}"))
            ->line("You can expect a formal quotation within **1 business day**. The quote will be valid for {$validityDays} days once issued.")
            ->when($notifiable instanceof User, fn ($m) => $m->action('View your quotes', route('account.quotes.index')))
            ->line('If you have any questions, feel free to reply to this email or contact us directly.')
            ->salutation("The {$storeName} team");
    }
}
