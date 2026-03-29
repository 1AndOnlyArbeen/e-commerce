<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controller;

class HomeController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allProducts = Product::all()->map(function ($p) {
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
        $byCategory = Product::all()->groupBy('category');

        return view('welcome', compact('allProducts', 'byCategory'));
    }

    public function create() {}


    public function store(Request $request) {}


    public function show(string $id) {}


    public function edit(string $id) {}

    public function update(Request $request, string $id) {}


    public function destroy(string $id) {}
}
