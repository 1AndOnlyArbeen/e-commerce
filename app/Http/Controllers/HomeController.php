<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $category = 'All')

    {

     $query = Product::query();

    if ($category !== 'All') {
        $query->where('category', $category);
    }
        $products = $query->paginate(15);
        $products->getCollection()->transform (function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'unit' => $p->unit,
                'category' => $p->category,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
                'tag' => $p->tag,
                'tagBg' => '#e8f5e9',
                'tagColor' => '#2e7d32',
            ];
        });

        return view('welcome', compact('products','category'));
    }
    

    public function create() {}


    public function store(Request $request) {}


    public function show(string $id) {}


    public function edit(string $id) {}

    public function update(Request $request, string $id) {}


    public function destroy(string $id) {}
}
