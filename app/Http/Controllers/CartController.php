<?php

namespace App\Http\Controllers;
use App\Models\CartItem;



class CartController extends Controller
{
    // Add to cart
    public function add(Request $request)
    {
        if (!auth()->check()) {
            // guest — tell frontend to store in localStorage
            return response()->json(['guest' => true]);
        }

        $item = CartItem::where('user_id', auth()->id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($item) {
            $item->increment('quantity', $request->quantity ?? 1);
        } else {
            CartItem::create([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity ?? 1,
            ]);
        }

        return response()->json(['success' => true]);
    }

    // Get cart
    public function get()
    {
        if (!auth()->check()) {
            return response()->json(['guest' => true]);
        }

        $items = CartItem::with('product')
                         ->where('user_id', auth()->id())
                         ->get();

        return response()->json($items);
    }

    // Remove item
    public function remove(Request $request)
    {
        CartItem::where('user_id', auth()->id())
                ->where('product_id', $request->product_id)
                ->delete();

        return response()->json(['success' => true]);
    }

    // Merge guest cart into DB after login
    public function merge(Request $request)
    {
        $guestCart = $request->cart; // array from localStorage

        foreach ($guestCart as $item) {
            $existing = CartItem::where('user_id', auth()->id())
                                ->where('product_id', $item['product_id'])
                                ->first();
            if ($existing) {
                $existing->increment('quantity', $item['quantity']);
            } else {
                CartItem::create([
                    'user_id'    => auth()->id(),
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
