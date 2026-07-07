<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Broadcast whenever an order's customer-visible state changes (status,
 * SAP/KRA progress, or receipt availability) so open order-details pages
 * refresh live. Fired from the Order model on relevant attribute changes.
 */
class OrderUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Order $order) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('orders.'.$this->order->id);
    }

    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->order->status->value,
            'sap_sync_status' => $this->order->sap_sync_status?->value,
            'has_receipt' => $this->order->hasKraReceipt(),
        ];
    }
}
