<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class DeliveryConfirmationController extends Controller
{
    public function show(Shipment $shipment): View
    {
        $order = $shipment->order->load('items');

        return view('pages.delivery.confirm', [
            'shipment' => $shipment,
            'order' => $order,
            'confirmPostUrl' => URL::signedRoute('delivery.confirm.submit', ['shipment' => $shipment]),
            'disputeUrl' => URL::signedRoute('delivery.dispute', ['shipment' => $shipment]),
        ]);
    }

    public function confirm(Shipment $shipment): View
    {
        if (! $shipment->customer_confirmed_at) {
            $shipment->update(['customer_confirmed_at' => now()]);
        }

        return view('pages.delivery.confirmed', [
            'shipment' => $shipment,
            'order' => $shipment->order->load('items'),
            'disputeUrl' => URL::signedRoute('delivery.dispute', ['shipment' => $shipment]),
        ]);
    }

    public function showDispute(Shipment $shipment): View
    {
        return view('pages.delivery.dispute', [
            'shipment' => $shipment,
            'order' => $shipment->order,
            'confirmUrl' => URL::signedRoute('delivery.confirm', ['shipment' => $shipment]),
            'submitUrl' => URL::signedRoute('delivery.dispute.submit', ['shipment' => $shipment]),
        ]);
    }

    public function submitDispute(Request $request, Shipment $shipment): View
    {
        $request->validate(['notes' => 'required|string|max:2000']);

        $shipment->update([
            'customer_disputed_at' => $shipment->customer_disputed_at ?? now(),
            'customer_notes' => $request->input('notes'),
        ]);

        return view('pages.delivery.dispute-submitted', [
            'shipment' => $shipment,
            'order' => $shipment->order,
        ]);
    }
}
