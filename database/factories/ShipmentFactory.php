<?php

namespace Database\Factories;

use App\Enums\ShipmentStatus;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shipment>
 */
class ShipmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'status' => ShipmentStatus::PENDING,
        ];
    }

    public function delivered(): static
    {
        return $this->state([
            'status' => ShipmentStatus::DELIVERED,
            'delivered_at' => now()->subHours(2),
        ]);
    }

    public function outForDelivery(): static
    {
        return $this->state(['status' => ShipmentStatus::OUT_FOR_DELIVERY]);
    }

    public function withDriver(): static
    {
        return $this->state([
            'driver_name' => fake()->name(),
            'driver_phone' => '07'.fake()->numerify('########'),
        ]);
    }
}
