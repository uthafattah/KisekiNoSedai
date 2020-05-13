<?php

namespace App\Http\Controllers;

use App\Store;
Use App\StatusStore;
use Illuminate\Http\Request;
use App\Http\Resources\Store as StoreResource;
use App\Http\Resources\StoreCollection as StoreResourceCollection;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'stores' => new StoreResourceCollection(Store::orderBy($sortBy, $orderBy)->paginate($per_page)),
            'status_stores' => StatusStore::pluck('name')->all()
        ], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $store = Store::where('name', 'LIKE', "%$id%")->paginate(10);
        return response()->json(['store' => new StoreResourceCollection($store)], 200);
    }

    public function search($id)
    {
        $store = Store::where('id', '=', "$id")->first();
        return response()->json(['store' => new StoreResource($store)], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function changeStatus(Request $request)
    {
        $status_store = StatusStore::where('name', $request->status_store)->first();
        $store = Store::find($request->store);
        $store->status_store()->dissociate($store->status_store);
        $store->status_store()->associate($status_store);
        $store->save();
        return response()->json(['store' => new StoreResource($store)], 200);
    }

    public function status(Request $request, $id)
    {
        $status_store = StatusStore::where('name', $request->status_store)->first();
        $store = Store::find($id);
        $store->status_store()->dissociate($store->status_store);
        $store->status_store()->associate($status_store);
        $store->save();
        return response()->json(['store' => new StoreResource($store)], 200);
    }
}
