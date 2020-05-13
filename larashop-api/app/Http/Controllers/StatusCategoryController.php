<?php

namespace App\Http\Controllers;

use App\StoreCategory;
use Illuminate\Http\Request;
use App\Http\Resources\StoreCategory as StoreCategoryResource;
use App\Http\Resources\StoreCategoryCollection as StoreCategoryResourceCollection;

class StoreCategoryController extends Controller
{
    public function index()
    {
        //return response()->json(['store_category' => StoreCategory::all()], 200);
        return new StoreCategoryResourceCollection(StoreCategory::paginate(5));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
