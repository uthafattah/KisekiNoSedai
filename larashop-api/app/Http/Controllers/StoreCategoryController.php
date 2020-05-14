<?php

namespace App\Http\Controllers;

use App\StoreCategory;
use App\Store;
use Illuminate\Http\Request;
use App\Http\Resources\Store as StoreResource;
use App\Http\Resources\StoreCategory as StoreCategoryResource;
use App\Http\Resources\StoreCategoryCollection as StoreCategoryResourceCollection;

class StoreCategoryController extends Controller
{
    public function index()
    {
        return new StoreCategoryResourceCollection(StoreCategory::paginate(10));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function find($id)
    {
        $stores = StoreCategory::select('store_id')
            ->where('category_id', '=', "$id")
            ->get();   

        $store = [];
        foreach($stores as $temp){
            $temp2 = Store::where('id', '=', $temp->store_id)->first();
            $store[] = new StoreResource($temp2);
        }
        return response()->json(['store' => $store], 200);
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
