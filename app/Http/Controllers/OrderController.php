<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // Step 1 — session only, no DB
    public function saveAddress(Request $request)
    {
        $request->validate([
            'firstName'      => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'phone_number'   => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'state'          => 'nullable|string|max:100',
            'zip_code'       => 'nullable|string|max:20',
            'description'    => 'nullable|string|max:500',
        ]);

        session(['checkout_address' => $request->only([
            'firstName', 'last_name', 'phone_number',
            'street_address', 'city', 'state', 'zip_code', 'description'
        ])]);

        return response()->json(['success' => true]);
    }

    // Step 2 — session only, no DB
    public function savePayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,esewa,khalti,bank',
        ]);

        session(['checkout_payment' => $request->payment_method]);

        return response()->json(['success' => true]);
    }

    // Step 3 — everything goes to DB here at once
    public function placeOrder(Request $request)
    {
        $address = session('checkout_address');
        $payment = session('checkout_payment', 'cod');

        if (!$address) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please start checkout again.'], 422);
        }

        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 422);
        }

        // Create order
        $order = Order::create([
            'user_id'         => auth()->id(),
            'payment_method'  => $payment,
            'payment_status'  => 'pending',
            'status'          => 'pending',
            'currency'        => 'NPR',
            'shipping_amount' => 0,
            'shipping_method' => 'standard',
        ]);

        {/*

        logic for address 
        1. user add the first time address from the from given , then it get saved into datbase with order id and user id 
        2. when the user second time try to order the db is fetching the address and filling the form auto with the address
        3. when the user continue it check the db? is the user address match the previous addrress? if yes then dont change into address nor save leave as it is, 
        4. but when the user change the address then save the chnaged address
        5. when the user next time try to fetch the address when ordering it fetch the latest one..
         */}
        // Save address


       $existing = Address::where('user_id', auth()->id())->latest()->first();

if ($existing &&
    $existing->firstName      === $address['firstName'] &&
    $existing->last_name      === $address['last_name'] &&
    $existing->phone_number   === $address['phone_number'] &&
    $existing->street_address === $address['street_address'] &&
    $existing->city           === $address['city']
) {
    // Same address — just update order_id
    $existing->update(['order_id' => $order->id]);
} else if ($existing) {
    // Changed — update existing row
    $existing->update([
        'order_id'       => $order->id,
        'firstName'      => $address['firstName'],
        'last_name'      => $address['last_name'],
        'phone_number'   => $address['phone_number'],
        'street_address' => $address['street_address'],
        'city'           => $address['city'],
        'state'          => $address['state'] ?? null,
        'zip_code'       => $address['zip_code'] ?? null,
        'description'    => $address['description'] ?? null,
    ]);
} else {
    // First time — create new
    Address::create([
        'order_id'       => $order->id,
        'user_id'        => auth()->id(),
        'firstName'      => $address['firstName'],
        'last_name'      => $address['last_name'],
        'phone_number'   => $address['phone_number'],
        'street_address' => $address['street_address'],
        'city'           => $address['city'],
        'state'          => $address['state'] ?? null,
        'zip_code'       => $address['zip_code'] ?? null,
        'description'    => $address['description'] ?? null,
    ]);
}

        // Save items
        foreach ($cartItems as $item) {
            $unitPrice = (float) $item->product->price;
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'quantity'     => $item->quantity,
                'unit_amount'  => $unitPrice,
                'total_amount' => $unitPrice * $item->quantity,
            ]);
        }

        // Clear cart and session
        CartItem::where('user_id', auth()->id())->delete();
        session()->forget(['checkout_address', 'checkout_payment']);

        return response()->json([
            'success'      => true,
            'order_number' => 'ARB-' . strtoupper(substr(md5($order->id), 0, 6)),
            'order_id'     => $order->id,
        ]);
    }

    // Pre-fill last address
    public function getLastAddress()
    {
        $lastOrder = Order::where('user_id', auth()->id())
            ->whereHas('items')
            ->with('address')
            ->latest()
            ->first();

        if ($lastOrder && $lastOrder->address) {
            return response()->json(['found' => true, 'address' => $lastOrder->address]);
        }

        return response()->json(['found' => false]);
    }
}