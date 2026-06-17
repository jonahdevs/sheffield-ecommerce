<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\SapSyncStatus;
use App\Enums\ShipmentStatus;
use App\Models\Address;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\ShippingCarrier;
use App\Models\ShippingMethod;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\CarbonInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoricalOrderSeeder extends Seeder
{
    private ShippingMethod $standard;

    private ShippingMethod $express;

    private ShippingCarrier $carrier;

    private Warehouse $warehouse;

    private DeliveryZone $zone;

    private array $products = [];

    private array $customers = [];

    /** Payment channel distribution weights */
    private const CHANNELS = [
        ['state' => 'paystackMobileMoney', 'method' => 'mpesa',         'weight' => 45],
        ['state' => 'paystack',            'method' => 'card',           'weight' => 30],
        ['state' => 'paystackAirtel',      'method' => 'airtel',         'weight' => 15],
        ['state' => null,                  'method' => 'bank_transfer',  'weight' => 10],
    ];

    public function run(): void
    {
        $this->standard = ShippingMethod::where('slug', 'standard-delivery')->firstOrFail();
        $this->express = ShippingMethod::where('slug', 'express-delivery')->firstOrFail();
        $this->carrier = ShippingCarrier::where('slug', 'sheffield')->firstOrFail();
        $this->warehouse = Warehouse::where('slug', 'nairobi-hq')->firstOrFail();
        $this->zone = DeliveryZone::where('name', 'Nairobi & Surroundings')->firstOrFail();

        $this->loadProducts();
        $this->createCustomers();
        $this->seedHistoricalOrders();
    }

    private function createCustomers(): void
    {
        // 12 customers registered at spread intervals so the customer sparkline has data
        $offsets = [175, 160, 148, 132, 115, 101, 88, 74, 62, 49, 33, 18];

        foreach ($offsets as $daysAgo) {
            $registeredAt = now()->subDays($daysAgo)->addHours(rand(8, 18));

            $user = User::factory()->create([
                'created_at' => $registeredAt,
                'updated_at' => $registeredAt,
            ]);

            $address = Address::create([
                'user_id' => $user->id,
                'label' => 'Home',
                'name' => $user->name,
                'line1' => fake()->streetAddress(),
                'delivery_zone_id' => $this->zone->id,
                'county' => fake()->randomElement(['Nairobi', 'Kiambu', 'Mombasa', 'Nakuru', 'Kisumu', 'Machakos']),
                'is_default' => true,
            ]);

            $this->customers[] = ['user' => $user, 'address' => $address];
        }
    }

    private function seedHistoricalOrders(): void
    {
        // Walk back 180 days. Weekdays get 1–3 orders, weekends 0–1.
        for ($daysAgo = 180; $daysAgo >= 1; $daysAgo--) {
            $date = now()->subDays($daysAgo)->startOfDay();
            $count = $date->isWeekend() ? rand(0, 1) : rand(1, 3);

            for ($i = 0; $i < $count; $i++) {
                $placedAt = $date->copy()->addHours(rand(7, 20))->addMinutes(rand(0, 59));
                $this->seedOrder($placedAt, $daysAgo);
            }
        }
    }

    private function seedOrder(CarbonInterface $placedAt, int $daysAgo): void
    {
        $channel = $this->pickChannel();
        $customer = $this->customers[array_rand($this->customers)];

        $status = match (true) {
            $daysAgo > 14 => $this->weightedStatus(['completed' => 75, 'cancelled' => 15, 'processing' => 10]),
            $daysAgo > 7 => $this->weightedStatus(['completed' => 50, 'processing' => 30, 'out_for_delivery' => 20]),
            default => $this->weightedStatus(['processing' => 50, 'out_for_delivery' => 25, 'pending' => 15, 'completed' => 10]),
        };

        $subtotal = $this->randomPrice();
        $vat = (int) round($subtotal * 0.16);
        $delivery = rand(0, 1) ? 35000 : 0;
        $confirmedAt = $placedAt->copy()->addMinutes(rand(5, 60));
        $shippingMethod = rand(0, 3) === 0 ? $this->express : $this->standard;

        $attrs = [
            'user_id' => $customer['user']->id,
            'address_id' => $customer['address']->id,
            'delivery_zone_id' => $this->zone->id,
            'delivery_zone_name' => $this->zone->name,
            'shipping_method_id' => $shippingMethod->id,
            'shipping_name' => $customer['user']->name,
            'shipping_line1' => $customer['address']->line1,
            'shipping_city' => 'Nairobi',
            'shipping_state' => 'Nairobi',
            'shipping_country' => 'KE',
            'order_number' => Order::generateNumber(),
            'status' => OrderStatus::from($status),
            'payment_method' => $channel['method'],
            'subtotal_cents' => $subtotal,
            'vat_cents' => $vat,
            'delivery_cents' => $delivery,
            'installation_cents' => 0,
            'total_cents' => $subtotal + $vat + $delivery,
            'currency' => 'KES',
            'created_at' => $placedAt,
            'updated_at' => $placedAt,
        ];

        if ($status !== 'pending') {
            $attrs['confirmed_at'] = $confirmedAt;
        }

        if (in_array($status, ['out_for_delivery', 'completed'])) {
            $attrs['shipped_at'] = $confirmedAt->copy()->addHours(rand(4, 24));
        }

        if ($status === 'completed') {
            $deliveredAt = $confirmedAt->copy()->addDays(rand(1, 3));
            $attrs['delivered_at'] = $deliveredAt;
            $attrs['updated_at'] = $deliveredAt;
        }

        if ($status === 'cancelled') {
            $attrs['cancelled_at'] = $confirmedAt->copy()->addHours(rand(1, 12));
        }

        if (in_array($status, ['processing', 'out_for_delivery', 'completed'])) {
            [$sapStatus, $docEntry, $docNumber, $cuNumber] = $this->sapState($status, $daysAgo);
            $attrs['sap_sync_status'] = $sapStatus;
            $attrs['sap_synced_at'] = $confirmedAt->copy()->addMinutes(rand(2, 15));

            if ($docEntry) {
                $attrs['sap_doc_entry'] = $docEntry;
                $attrs['sap_doc_number'] = $docNumber;
            }

            if ($cuNumber) {
                $attrs['cu_number'] = $cuNumber;
            }
        }

        $order = Order::create($attrs);

        $this->attachItems($order, rand(1, 4));

        if ($status !== 'pending') {
            $this->createPayment($order, $channel, $confirmedAt);
        }

        if (in_array($status, ['out_for_delivery', 'completed'])) {
            Shipment::create([
                'order_id' => $order->id,
                'shipping_method_id' => $shippingMethod->id,
                'carrier_id' => $this->carrier->id,
                'tracking_number' => 'SHF-TRK-'.strtoupper(fake()->bothify('????####')),
                'status' => $status === 'completed' ? ShipmentStatus::DELIVERED : ShipmentStatus::OUT_FOR_DELIVERY,
                'booked_at' => $attrs['shipped_at'],
                'picked_up_at' => $attrs['shipped_at'],
                'delivered_at' => $status === 'completed' ? ($attrs['delivered_at'] ?? null) : null,
                'estimated_delivery_at' => $confirmedAt->copy()->addDays(2),
            ]);
        }
    }

    /** @return array{SapSyncStatus, ?string, ?string, ?string} */
    private function sapState(string $status, int $daysAgo): array
    {
        if ($status === 'completed' && $daysAgo > 3) {
            return [
                SapSyncStatus::COMPLETED,
                'DOC-'.fake()->numerify('####'),
                'INV-'.fake()->numerify('####'),
                'KRA-CU-'.fake()->numerify('######'),
            ];
        }

        if (in_array($status, ['completed', 'out_for_delivery'])) {
            return [SapSyncStatus::AWAITING_CU, 'DOC-'.fake()->numerify('####'), 'INV-'.fake()->numerify('####'), null];
        }

        // processing — realistic mix
        $roll = rand(1, 100);

        if ($roll <= 60) {
            return [SapSyncStatus::AWAITING_CU, 'DOC-'.fake()->numerify('####'), 'INV-'.fake()->numerify('####'), null];
        }

        if ($roll <= 80) {
            return [SapSyncStatus::PENDING, null, null, null];
        }

        if ($roll <= 90) {
            return [SapSyncStatus::SYNCING, null, null, null];
        }

        return [SapSyncStatus::FAILED, null, null, null];
    }

    private function createPayment(Order $order, array $channel, CarbonInterface $paidAt): void
    {
        $base = [
            'order_id' => $order->id,
            'amount_cents' => $order->total_cents,
            'paid_at' => $paidAt,
            'account_reference' => $order->order_number,
            'created_at' => $paidAt,
            'updated_at' => $paidAt,
        ];

        match ($channel['state']) {
            'paystackMobileMoney' => Payment::factory()->successful()->paystackMobileMoney()->create(array_merge($base, [
                'phone' => '2547'.fake()->numerify('########'),
                'mpesa_receipt' => strtoupper(fake()->bothify('???#####??')),
                'paystack_reference' => 'SHF-'.now()->year.'-'.fake()->numerify('#####').'-'.strtoupper(fake()->lexify('????????')),
            ])),
            'paystack' => Payment::factory()->successful()->paystack()->create(array_merge($base, [
                'paystack_reference' => 'SHF-'.now()->year.'-'.fake()->numerify('#####').'-'.strtoupper(fake()->lexify('????????')),
            ])),
            'paystackAirtel' => Payment::factory()->successful()->paystackAirtel()->create(array_merge($base, [
                'phone' => '2547'.fake()->numerify('########'),
                'paystack_reference' => 'SHF-'.now()->year.'-'.fake()->numerify('#####').'-'.strtoupper(fake()->lexify('????????')),
            ])),
            default => Payment::factory()->successful()->create(array_merge($base, [
                'provider' => 'bank_transfer',
                'phone' => null,
                'merchant_request_id' => null,
                'checkout_request_id' => null,
            ])),
        };
    }

    private function attachItems(Order $order, int $count): void
    {
        if (empty($this->products)) {
            return;
        }

        $selected = collect($this->products)->random(min($count, count($this->products)));

        foreach ($selected as $product) {
            $qty = rand(1, 3);
            $price = $product['price'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'product_snapshot' => ['name' => $product['name'], 'sku' => $product['sku'], 'model_number' => $product['model_number'] ?? null],
                'unit_price_cents' => $price,
                'quantity' => $qty,
                'line_total_cents' => $price * $qty,
                'tax_rate' => 16.00,
                'tax_cents' => (int) round($price * $qty * 0.16),
            ]);
        }
    }

    private function loadProducts(): void
    {
        $rows = DB::table('products')
            ->select('id', 'name', 'sku', 'model_number', 'price', 'sale_price')
            ->get();

        $this->products = $rows->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'sku' => $p->sku,
            'model_number' => $p->model_number,
            'price' => $p->sale_price ?? $p->price ?? 5000000,
        ])->toArray();
    }

    private function pickChannel(): array
    {
        $roll = rand(1, 100);
        $cumulative = 0;

        foreach (self::CHANNELS as $channel) {
            $cumulative += $channel['weight'];
            if ($roll <= $cumulative) {
                return $channel;
            }
        }

        return self::CHANNELS[0];
    }

    private function weightedStatus(array $weights): string
    {
        $total = array_sum($weights);
        $roll = rand(1, $total);
        $cumulative = 0;

        foreach ($weights as $status => $weight) {
            $cumulative += $weight;
            if ($roll <= $cumulative) {
                return $status;
            }
        }

        return array_key_first($weights);
    }

    private function randomPrice(): int
    {
        $roll = rand(1, 100);

        return match (true) {
            $roll <= 40 => rand(5, 20) * 100000,    // KES 5k–20k
            $roll <= 75 => rand(20, 80) * 100000,   // KES 20k–80k
            $roll <= 90 => rand(80, 150) * 100000,  // KES 80k–150k
            default => rand(150, 300) * 100000, // KES 150k–300k
        };
    }
}
