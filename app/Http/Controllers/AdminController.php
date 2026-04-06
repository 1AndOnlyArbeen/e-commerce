<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function index(Request $request, $category = 'All')
    {

        // adding the pagination
        $user = Auth::user();


        // for the order and customer data we can fetch it from the database and pass it to the view :
        $orders =Order::with(['address', 'Orderitems.product', 'user'])
    ->latest()
    ->paginate(20);

        // for the customer data we can fetch it from the database and pass it to the view :
        $customers = User::where('role', '!=', 'admin')
            ->withCount('orders')
            ->latest()
            ->get();

        // if not logged in OR not admin → redirect to store
        if (! $user || $user->role !== 'admin') {
            return redirect('/store');
        }

        $query = Product::query();
        if ($category !== 'All') {
            $query->where('category', $category);
        }

        $products = $query->paginate(15);
        if ($request->ajax()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => (string) $products->links(),
                'total' => $products->total(),
            ]);
        }

        $allProduct = Product::all();
        $byCategory = Product::all()->groupBy('category');
        $categories = Category::withCount('products')->get();

        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->orWhere('status', 'new')->count();
        $totalCustomers = User::where('role', '!=', 'admin')->count();
        $todayRevenue = Order::whereDate('created_at', today())
            ->with('items')
            ->get()
            ->sum(fn($o) => $o->items->sum('total_amount'));

        return view('admin', compact('allProduct', 'byCategory', 'products', 'categories', 'orders', 'customers', 'totalOrders', 'pendingOrders', 'totalCustomers', 'todayRevenue'));
    }

    public function create(Request $request) {}

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:60',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'unit' => 'required|string',
            'image' => 'nullable|image|max:20000',
            'stock_quantity' => 'nullable|integer|min:0',
        ]);

        $slug = Str::slug($request->name);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images', $fileName, 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'price' => $request->price,
            'category' => $request->category,
            'unit' => $request->unit,
            'description' => $request->description,
            'tag' => $request->tag,
            'stock_quantity' => $request->stock_quantity ?? 0,
            'image' => $imagePath,
            'is_active' => true,
            'in_stock' => true,
            'on_sale' => false,
        ]);

        return redirect('/admin');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        // step to edit the product

        $Products = Product::findOrFail($id);

        return view('admin');
    }

    public function update(Request $request, string $id)
    {

        // product edit and image also edit

        $Products = Product::findOrFail($id);
        $imagePath = $Products->image;

        if ($request->hasFile('image')) {

            // delete old image
            if ($Products->image && file_exists(storage_path('app/public/' . $Products->image))) {
                unlink(storage_path('app/public/' . $Products->image));
            }

            // upload new image
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();

            $imagePath = $request->file('image')->storeAs(
                'images',
                $fileName,
                'public'
            );
        }

        $Products->update([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'tag' => $request->tag,
            'stock_quantity' => $request->stock_quantity,
            'unit' => $request->unit,
            'image' => $imagePath,

        ]);

        return redirect('/admin');
    }

    public function destroy(string $id)
    {
        $products = Product::findOrFail($id);

        // delete the image and data of that id

        if ($products->image && file_exists(storage_path('app/public/' . $products->image))) {
            unlink(storage_path('app/public/' . $products->image));
        }

        // deleting from database

        $products->delete();

        return redirect('admin');
    }
}
