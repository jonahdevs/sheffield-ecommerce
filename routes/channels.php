<?php

use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin.notifications', function ($user) {
    return $user->hasRole(['admin', 'staff']);
});

Broadcast::channel('admin.sap-sync', function ($user) {
    return $user->hasRole(['admin', 'staff']);
});

Broadcast::channel('orders.{order}', function ($user, Order $order) {
    return $order->user_id === $user->id || $user->hasRole(['admin', 'staff']);
});
