<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// withoutOverlapping on every entry: each of these walks a catalogue-sized set
// whose runtime grows with the data, and a run that outlasts its own interval
// would otherwise start a second copy mid-flight (double reminder emails, two
// processes rewriting sitemap.xml).

// Flip scheduled products live once their publish time has passed.
Schedule::command('products:publish-scheduled')->everyFiveMinutes()->withoutOverlapping();

// Regenerate the static sitemap.xml daily.
Schedule::command('sitemap:generate')->daily()->withoutOverlapping();

// Flip sent quotes whose validity window has lapsed to expired.
Schedule::command('quotes:expire')->daily()->withoutOverlapping();

// Email customers about carts they left idle (abandoned-cart reminders).
Schedule::command('cart:remind-abandoned')->everyFifteenMinutes()->withoutOverlapping();

// Erase raw gateway payloads (PII) past the 5-year retention window - DPA 2019
// storage limitation; structured payment columns are retained for the record.
Schedule::command('payments:prune-payloads')->weekly()->withoutOverlapping();

Schedule::command('queue:work --stop-when-empty --queue=default,sap --tries=3 --max-time=55')
    ->everyMinute()
    ->withoutOverlapping();
