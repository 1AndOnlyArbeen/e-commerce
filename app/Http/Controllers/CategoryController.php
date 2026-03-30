<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    
    public function index()
    {
       
    }

  
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {


    $request -> validate([
        'name' =>'required|string|max:60',
        'slug' =>'required|string',
        'image' =>'required|string',
        'is_active' =>'required',     
        
    ]);

    //for slug 

        $slug = Str::slug($request->name);
        $count = Category::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        //for image handeling 

        $imagePath = null;
        if($request->hasFile('image')){
            $fileName = time().'_'.$request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images', $fileName,'public');

        }
        Category::create([
            'name'=>$request->name,
            'slug'=>$request->slug,
            'image'=>$request->$imagePath,,

        ]);
        return redirect('/category');



      
    }

  
    public function show(string $id)
    {
        
    }

  
    public function edit(string $id)
    {
        
    }

    
    public function update(Request $request, string $id)
    {
        
    }

   
    public function destroy(string $id)
    {
        
    }
}
