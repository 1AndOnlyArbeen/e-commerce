<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {
        $user = Auth::user();

        // if not logged in OR not admin → redirect to store
        if (!$user || $user->role !== 'admin') {
            return redirect('/store');
        }

        $allProduct = Product::all();
        $byCategory = Product::all()->groupBy('category');

        return view('admin', compact('allProduct', 'byCategory'));
    }

    public function create(Request $request) {}


    public function store(Request $request)


    {

        $request->validate([
            'name'           => 'required|string|max:60',
            'price'          => 'required|numeric|min:0',
            'category'       => 'required|string',
            'unit'           => 'required|string',
            'image'          => 'nullable|image|max:20000',
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
            'name'           => $request->name,
            'slug'           => $slug,
            'price'          => $request->price,
            'category'       => $request->category,
            'unit'           => $request->unit,
            'description'    => $request->description,
            'tag'            => $request->tag,
            'stock_quantity' => $request->stock_quantity ?? 0,
            'image'          => $imagePath,
            'is_active'      => true,
            'in_stock'       => true,
            'on_sale'        => false,
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

        //deleting from database 

        $products->delete();
        return redirect('admin');

    }
}
