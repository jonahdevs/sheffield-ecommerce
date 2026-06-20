<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\Account\AccountSuspended;
use Cog\Laravel\Ban\Events\ModelWasBanned;

/**
 * Emails a customer a suspension notice whenever they are banned, via the
 * package's ModelWasBanned event so every ban path is covered.
 */
class SendBanNotification
{
    public function handle(ModelWasBanned $event): void
    {
        $user = $event->model;

        if (! $user instanceof User || ! $user->email) {
            return;
        }

        $user->notify(new AccountSuspended($event->ban->comment));
    }
}
