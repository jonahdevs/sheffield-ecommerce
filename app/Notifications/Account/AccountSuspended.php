<?php

namespace App\Notifications\Account;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Plain notice sent to a customer when their account is suspended (banned), so
 * they understand why they can no longer sign in and how to reach support. Sent
 * over mail only and independent of notification preferences — it is a critical
 * account notice, not a marketing or order update.
 */
class AccountSuspended extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly ?string $reason = null) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Your '.config('app.name').' account has been suspended')
            ->greeting('Hi '.$notifiable->name.',')
            ->line('We\'re writing to let you know that your '.config('app.name').' account has been suspended, and you will no longer be able to sign in.');

        if ($this->reason) {
            $message->line('Reason: '.$this->reason);
        }

        return $message
            ->line('If you believe this was a mistake or would like to discuss it, please reply to this email or contact our support team and we\'ll be happy to help.')
            ->salutation('Thank you, The '.config('app.name').' Team');
    }
}
