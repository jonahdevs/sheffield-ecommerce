<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear generated documents from previous seed runs so they don't accumulate.
        foreach (['packing-lists', 'delivery-notes', 'kra-receipts', 'quotations'] as $dir) {
            Storage::disk('local')->deleteDirectory($dir);
        }

        // migrate:fresh drops the media table but never touches the media disk, so
        // every previous seed run's Spatie media folders were piling up as orphans
        // (storage/app/media grew past 3GB across repeated reseeds). Nothing on this
        // disk is reachable once the media table is dropped, so wipe it before
        // ProductSeeder/MediaSeeder repopulate it from scratch.
        foreach (Storage::disk('media')->directories() as $dir) {
            Storage::disk('media')->deleteDirectory($dir);
        }
        File::deleteDirectory(storage_path('media-library/temp'));

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            BrandSeeder::class,
            AttributeSeeder::class,
            TaxClassSeeder::class,
            ProductSeeder::class,
            ShowroomSeeder::class,
            PageSeeder::class,
            DeliveryZoneSeeder::class,
            LogisticsSeeder::class,
            // AddressSeeder::class,
            // OrderSeeder::class,
            // CouponSeeder::class,
            // QuoteSeeder::class,
            // ReviewSeeder::class,
            // BannedIpSeeder::class,
            // Must run last: builds image conversions for all media attached above.
            MediaSeeder::class,
        ]);
    }
}
