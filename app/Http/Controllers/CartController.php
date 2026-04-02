<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    /**
     * Add or update a cart item.
     * Uses updateOrCreate so it SETS the exact quantity instead of
     
     */
    public function add(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['guest' => true]);
        }

        CartItem::updateOrCreate(
            [
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
            ],
            [
                // JS always sends the new TOTAL quantity, not just +1
                'quantity' => $request->quantity,
            ]
        );

        return response()->json(['success' => true]);
    }

    

    /**
     * Return all cart items for the logged-in user.
     * Includes product name, price, unit, image so the cart drawer
     * can render correctly even when those products are not on the
     * current paginated page.
     */
    public function get()
    {
        if (!auth()->check()) {
            // Return empty array for guests — JS uses localStorage instead
            return response()->json([]);
        }

        $items = CartItem::where('user_id', auth()->id())
            ->with('product') // eager-load product so we can return its details
            ->get()
            ->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    // These extra fields let the cart drawer work even when
                    // the product is not on the current paginated page
                    'name'  => $item->product->name  ?? 'Unknown',
                    'price' => $item->product->price ?? 0,
                    'unit'  => $item->product->unit  ?? '',
                    // Full public URL so <img src> works directly
                    'image' => $item->product && $item->product->image
                        ? asset('storage/' . $item->product->image)
                        : null,
                ];
            });

        return response()->json($items);
    }

    /**
     * Decrement or delete a cart item.
     * JS sends the new quantity after decrement.
     * If quantity reaches 0, the row is deleted entirely.
     */
    public function remove(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['guest' => true]);
        }

        $item = CartItem::where('user_id', auth()->id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if (!$item) {
            return response()->json(['success' => true]);
        }

        if ($request->quantity && $request->quantity > 0) {
            // Update to the exact new quantity JS calculated
            $item->update(['quantity' => $request->quantity]);
        } else {
            // Quantity hit 0 — remove the row
            $item->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Merge guest (localStorage) cart into DB after login.
     * Called once right after the user logs in.
     * updateOrCreate prevents duplicates.
     */
    public function merge(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['guest' => true]);
        }

        foreach ($request->cart as $item) {
            CartItem::updateOrCreate(
                [
                    'user_id'    => auth()->id(),
                    'product_id' => $item['product_id'],
                ],
                [
                    'quantity' => $item['quantity'],
                ]
            );
        }

        return response()->json(['success' => true]);
    }
}