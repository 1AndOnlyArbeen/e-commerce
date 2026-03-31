<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return redirect('/admin');
    }

    public function create() {}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10000',
            'is_active' => 'nullable',
        ]);

        $slug = Str::slug($request->name);
        $count = Category::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug.'-'.($count + 1);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $fileName = time().'_'.$request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images', $fileName, 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect('/admin')->with('success', 'Category added!');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        return redirect('/admin');
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $imagePath = $category->image;

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(storage_path('app/public/'.$category->image))) {
                unlink(storage_path('app/public/'.$category->image));
            }
            $fileName = time().'_'.$request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images', $fileName, 'public');
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect('/admin')->with('success', 'Category updated!');
    }

    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();

        return redirect('/admin')->with('success', 'Category deleted!');
    }
}
