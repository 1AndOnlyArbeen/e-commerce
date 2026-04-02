<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\OrderItem;


    // i have to make the order controller to handle the order process
    // 1, i have to get the address from the request, and save it to the database, when the user hit continue rather it fill all other info in the Address Table .
    // 2, i have to get the payment method from the request, and save it to the database, in same order table, when the user hit continue rather it fill all other info, but for now i wil do for cash on delivery, and i will add other payment method later.
    // 3, i have to get the oder details form the user cart database and show to the user in review order page and then when the user hit place order, i will save the order details to the database and clear the user cart database.
    // but the catch is i will not give tha ! auth for chekout if the user is non auth or logged in he has to redirect to login page and then after login he will redirect to checkout page again, but if the user is auth or logged in he can access the checkout page directly without redirecting to login page.



// get the address details ffrom the request and saving into the addressesand description as i have added the description column 

class OrderController extends Controller
{
    /**
     * Step 1 — Save delivery address.
     * Creates the Order shell + Address row together.
     * Stores order_id in session so Step 2 & 3 can find it.
     * If the user already has a previous address we return it
     * so the blade can pre-fill the form.
     */
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

        // Create the order shell (no items yet — those come at Step 3)
        $order = Order::create([
            'user_id'         => auth()->id(),
            'payment_method'  => 'cod',
            'payment_status'  => 'pending',
            'status'          => 'pending',
            'currency'        => 'NPR',
            'shipping_amount' => 0,
            'shipping_method' => 'standard',
        ]);

        Address::create([
            'order_id'       => $order->id,
            'firstName'      => $request->firstName,
            'last_name'      => $request->last_name,
            'phone_number'   => $request->phone_number,
            'street_address' => $request->street_address,
            'city'           => $request->city,
            'state'          => $request->state,
            'zip_code'       => $request->zip_code,
            'description'    => $request->description,
        ]);

        session(['pending_order_id' => $order->id]);

        return response()->json([
            'success'  => true,
            'order_id' => $order->id,
        ]);
    }

    /**
     * Step 2 — Save payment method onto the existing pending order.
     */
    public function savePayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,esewa,khalti,bank',
        ]);

        $orderId = session('pending_order_id');

        if (!$orderId) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please start checkout again.',
            ], 422);
        }

        $order = Order::where('id', $orderId)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        $order->update(['payment_method' => $request->payment_method]);

        return response()->json(['success' => true]);
    }

    /**
     * Step 3 — Confirm & place the order.
     * Creates OrderItem rows from the DB cart, then clears the cart.
     */
    public function placeOrder(Request $request)
    {
        $orderId = session('pending_order_id');

        if (!$orderId) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please start checkout again.',
            ], 422);
        }

        $order = Order::where('id', $orderId)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        $cartItems = CartItem::where('user_id', auth()->id())
                             ->with('product')
                             ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ], 422);
        }

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

        $order->update(['status' => 'confirmed']);

        // Clear DB cart
        CartItem::where('user_id', auth()->id())->delete();

        session()->forget('pending_order_id');

        $orderNumber = 'ARB-' . strtoupper(substr(md5($order->id . now()), 0, 6));

        return response()->json([
            'success'      => true,
            'order_number' => $orderNumber,
            'order_id'     => $order->id,
        ]);
    }

    /**
     * Called by the blade on checkout open (AJAX GET).
     * Returns the last address the user used so the form can be pre-filled.
     */
    public function getLastAddress()
    {
        // Find the most recent order for this user that has an address
        $lastOrder = Order::where('user_id', auth()->id())
                          ->with('address')
                          ->latest()
                          ->first();

        if ($lastOrder && $lastOrder->address) {
            return response()->json([
                'found'   => true,
                'address' => $lastOrder->address,
            ]);
        }

        return response()->json(['found' => false]);
    }
}