<?php

use App\Models\User;
use App\Notifications\Account\AccountSuspended;
use Illuminate\Support\Facades\Notification;

it('emails the customer a suspension notice when they are banned', function () {
    Notification::fake();

    $user = User::factory()->create();

    $user->ban(['comment' => 'Fraudulent orders']);

    Notification::assertSentTo($user, AccountSuspended::class, function ($notification) {
        return $notification->reason === 'Fraudulent orders';
    });
});

it('sends the notice over mail only', function () {
    Notification::fake();

    $user = User::factory()->create();
    $user->ban();

    Notification::assertSentTo($user, AccountSuspended::class, function ($notification, $channels) {
        return $channels === ['mail'];
    });
});

it('renders a subject and greeting in the suspension mail', function () {
    $user = User::factory()->create(['name' => 'Jane Doe']);

    $mail = (new AccountSuspended('Spam'))->toMail($user);

    expect($mail->subject)->toContain('suspended')
        ->and($mail->greeting)->toBe('Hi Jane Doe,')
        ->and($mail->introLines)->toContain('Reason: Spam');
});
