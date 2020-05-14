<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection as CategoryResourceCollection;

class CategoryController extends Controller
{
    public function all()
    {
        return response()->json(['categories' => Category::all()], 200);
    }
    
    public function pluck()
    {
        return response()->json(['categories' => Category::pluck('name')->all()], 200);
    }

    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'categories' => new CategoryResourceCollection(Category::orderBy($sortBy, $orderBy)->paginate($per_page))
        ], 200);
    }

    public function store(Request $request)
    {
        $photo = $request->photo ? $request->photo : 'photos/no_categories.png';
        $category = new Category([
            'name' => $request->name,
            'slug' => \Str::slug($request->name, '-'),
            'photo' => $photo,
        ]);
        $category->save();
        return response()->json(['category' => new CategoryResource($category)], 200);
    }

    public function show($id)
    {
        $category = Category::where('name', 'LIKE', "%$id%")->paginate(10);
        return response()->json(['category' => new CategoryResourceCollection($category)], 200);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name, '-');
        $category->save();
        return response()->json(['category' => new CategoryResource($category)], 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id)->delete();
        return response()->json(['category' => $category], 200);
    }

    public function verifyCategory(Request $request) 
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        return response()->json(['message' => 'Valid Category Name'], 200);
    }
}
