<?php

namespace App\Notifications;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuoteRequest extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Quote $quote) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $quote = $this->quote->load('items');

        return (new MailMessage)
            ->subject("New quote request — {$quote->quote_number}")
            ->greeting('New quote request received')
            ->line("**{$quote->contact_name}** has submitted a quote request.")
            ->line("**Quote number:** {$quote->quote_number}")
            ->line("**Contact:** {$quote->contact_email}".($quote->contact_phone ? " · {$quote->contact_phone}" : ''))
            ->when($quote->contact_company, fn ($m) => $m->line("**Company:** {$quote->contact_company}"))
            ->line("**Items:** {$quote->items->count()}")
            ->when($quote->delivery_required, fn ($m) => $m->line("**Delivery required to:** {$quote->delivery_address}"))
            ->when($quote->notes, fn ($m) => $m->line("**Notes:** {$quote->notes}"))
            ->action('Review quote', route('admin.quotes.show', $quote));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'quote_request',
            'quote_id' => $this->quote->id,
            'quote_number' => $this->quote->quote_number,
            'contact_name' => $this->quote->contact_name,
            'contact_company' => $this->quote->contact_company,
            'url' => route('admin.quotes.show', $this->quote),
        ];
    }
}
