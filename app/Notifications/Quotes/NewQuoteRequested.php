<?php

namespace App\Notifications\Quotes;

use App\Models\Quote;
use App\Notifications\Concerns\RespectsStaffPreferences;
use App\Notifications\Messages\WhatsAppMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuoteRequested extends Notification implements ShouldQueue
{
    use Queueable;
    use RespectsStaffPreferences;

    public function __construct(public Quote $quote) {}

    protected function staffGlobalKey(): ?string
    {
        return 'staff_new_quote';
    }

    protected function staffPreferenceKey(): ?string
    {
        return 'new_quote';
    }

    protected function supportsInApp(): bool
    {
        return true;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $quote = $this->quote->load('items');
        $who = $quote->contact_name ?: ($quote->user?->name ?? 'A customer');

        return (new MailMessage)
            ->subject('New quote request - '.$quote->quote_number)
            ->markdown('mails.staff.new-quote', [
                'who' => $who,
                'quoteNumber' => $quote->quote_number,
                'email' => $quote->contact_email,
                'phone' => $quote->contact_phone,
                'company' => $quote->contact_company,
                'items' => $quote->items,
                'deliveryAddress' => $quote->delivery_required ? $quote->delivery_address : null,
                'notes' => $quote->notes,
                'url' => route('admin.quotes.show', $quote),
            ]);
    }

    public function toWhatsapp(object $notifiable): WhatsAppMessage
    {
        $quote = $this->quote->loadCount('items');
        $who = $quote->contact_name ?: ($quote->user?->name ?? 'A customer');

        return WhatsAppMessage::template('staff_new_quote')
            ->body(
                $who,
                $quote->quote_number,
                (string) $quote->items_count,
            );
    }

    /** @return array<string, mixed> */
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
