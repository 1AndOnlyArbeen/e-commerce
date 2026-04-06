<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request, $category = 'All')
    {
        $query = Product::query();

        if ($category !== 'All') {
            $query->where('category', $category);
        }

        $products = $query->paginate(15);
        $categories = Category::where('is_active', 1)->get();

        $products->getCollection()->transform(function ($p) {
            return [
                'id'       => $p->id,
                'name'     => $p->name,
                'price'    => $p->price,
                'unit'     => $p->unit,
                'category' => $p->category,
                'image'    => $p->image ? asset('storage/' . $p->image) : null,
                'tag'      => $p->tag,
                'tagBg'    => '#e8f5e9',
                'tagColor' => '#2e7d32',
            ];
        });

        $orders = collect([]);

        if (auth()->check()) {
            try {
                $orders = auth()->user()->orders()
                    ->with(['items.product', 'address'])
                    ->latest()
                    ->get()
                    ->filter(fn($order) => $order->items->count() > 0)
                    ->map(function ($order) {
                        $addr = $order->address;
                        return [
                            'id'             => $order->id,
                            'order_number'   => 'ARB-' . strtoupper(substr(md5($order->id), 0, 6)),
                            'placed_at'      => $order->created_at,
                            'status'         => $order->staus ?? 'pending',
                            'payment_method' => $order->payment_method ?? 'cod',
                            'payment_status' => $order->payment_status ?? 'pending',
                            'subtotal'       => $order->items->reduce(fn($carry, $i) => $carry + ($i->unit_amount * $i->quantity), 0),
                            'total'          => $order->items->reduce(fn($carry, $i) => $carry + ($i->unit_amount * $i->quantity), 0),
                            'address'        => [
                                'name'   => $addr ? $addr->fullName() : '',
                                'phone'  => $addr->phone_number ?? '',
                                'street' => $addr->street_address ?? '',
                                'city'   => $addr->city ?? '',
                                'state'  => $addr->state ?? '',
                                'postal' => $addr->zip_code ?? '',
                                'note'   => $addr->description ?? '',
                            ],
                            'items' => $order->items
                                ->filter(fn($item) => $item->product !== null)
                                ->map(fn($item) => [
                                    'name'  => $item->product->name,
                                    'unit'  => $item->product->unit,
                                    'price' => $item->unit_amount,
                                    'qty'   => $item->quantity,
                                    'image' => $item->product->image ? asset('storage/' . $item->product->image) : null,
                                ])->values(),
                        ];
                    })->values();
            } catch (\Exception $e) {
                $orders = collect([]);
            }
        }

        return view('welcome', compact('products', 'categories', 'category', 'orders'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}