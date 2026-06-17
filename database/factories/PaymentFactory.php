<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'provider' => 'mpesa',
            'status' => PaymentStatus::PENDING,
            'amount_cents' => fake()->numberBetween(1000, 5000000),
            'currency' => 'KES',
            'phone' => '2547'.fake()->numerify('########'),
            'account_reference' => 'SHF-'.now()->year.'-'.fake()->numerify('#####'),
            'merchant_request_id' => fake()->uuid(),
            'checkout_request_id' => 'ws_CO_'.fake()->numerify('############'),
        ];
    }

    public function stripe(): static
    {
        return $this->state([
            'provider' => 'stripe',
            'phone' => null,
            'merchant_request_id' => null,
            'checkout_request_id' => null,
            'stripe_payment_intent_id' => 'pi_test_'.fake()->bothify('??????????'),
        ]);
    }

    public function paystack(): static
    {
        return $this->state([
            'provider' => 'paystack',
            'phone' => null,
            'merchant_request_id' => null,
            'checkout_request_id' => null,
            'channel' => 'card',
            'paystack_reference' => 'SHF-'.now()->year.'-'.fake()->numerify('#####').'-'.strtoupper(fake()->lexify('????????')),
        ]);
    }

    public function paystackMobileMoney(): static
    {
        return $this->state([
            'provider' => 'paystack',
            'channel' => 'mobile_money',
            'merchant_request_id' => null,
            'checkout_request_id' => null,
            'paystack_reference' => 'SHF-'.now()->year.'-'.fake()->numerify('#####').'-'.strtoupper(fake()->lexify('????????')),
        ]);
    }

    public function paystackAirtel(): static
    {
        return $this->state([
            'provider' => 'paystack',
            'channel' => 'airtel',
            'merchant_request_id' => null,
            'checkout_request_id' => null,
            'paystack_reference' => 'SHF-'.now()->year.'-'.fake()->numerify('#####').'-'.strtoupper(fake()->lexify('????????')),
        ]);
    }

    public function successful(): static
    {
        return $this->state(function (array $attributes) {
            $provider = $attributes['provider'] ?? 'mpesa';
            $channel = $attributes['channel'] ?? null;
            $isPaystackCard = $provider === 'paystack' && $channel === 'card';
            $isPaystackMobile = $provider === 'paystack' && in_array($channel, ['mobile_money', 'airtel'], true);

            return array_filter([
                'status' => PaymentStatus::SUCCESS,
                'paid_at' => now(),
                // Daraja M-Pesa success fields
                'mpesa_receipt' => $provider === 'mpesa' ? strtoupper(fake()->bothify('???#####??')) : null,
                'result_code' => $provider === 'mpesa' ? 0 : null,
                'result_desc' => $provider === 'mpesa' ? 'The service request is processed successfully.' : null,
                // Stripe success fields
                'stripe_charge_id' => $provider === 'stripe' ? 'ch_test_'.fake()->bothify('??????????') : null,
                // Paystack success fields
                'authorization_code' => $provider === 'paystack' ? 'AUTH_'.fake()->bothify('??????????') : null,
                'mpesa_receipt' => $isPaystackMobile ? strtoupper(fake()->bothify('???#####??')) : null,
                // Card details for card-based payments
                'card_brand' => ($isPaystackCard || $provider === 'stripe') ? 'visa' : null,
                'card_last4' => ($isPaystackCard || $provider === 'stripe') ? '4242' : null,
            ], fn ($v) => $v !== null);
        });
    }

    public function failed(): static
    {
        return $this->state([
            'status' => PaymentStatus::FAILED,
            'result_code' => 1032,
            'result_desc' => 'Request cancelled by user',
        ]);
    }
}
