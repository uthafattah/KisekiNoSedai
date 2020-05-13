<?php

namespace App\Http\Controllers;

use App\StatusStore;
use Illuminate\Http\Request;
use App\Http\Resources\StatusStore as StatusStoreResource;
use App\Http\Resources\StatusStoreCollection as StatusStoreResourceCollection;

class StatusStoreController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'status_stores' => new StatusStoreResourceCollection(StatusStore::orderBy($sortBy, $orderBy)->paginate($per_page))
        ], 200);
    }

    public function store(Request $request)
    {
        $status_store = new StatusStore([
            'name' => $request->name,
            'slug' => \Str::slug($request->name, '-'),
        ]);
        $status_store->save();
        return response()->json(['status_store' => new StatusStoreResource($status_store)], 200);
    }

    public function show($id)
    {
        $status_store = StatusStore::where('name', 'LIKE', "%$id%")->paginate(10);
        return response()->json(['status_store' => new StatusStoreResourceCollection($status_store)], 200);
    }

    public function update(Request $request, $id)
    {
        $status_store = StatusStore::find($id);
        $status_store->name = $request->name;
        $status_store->slug = \Str::slug($request->name, '-');
        $status_store->save();
        return response()->json(['status_store' => new StatusStoreResource($status_store)], 200);
    }
    
    public function destroy($id)
    {
        $status_store = StatusStore::find($id)->delete();
        return response()->json(['status_store' => $status_store], 200);
    }

    public function verifyStatus(Request $request) 
    {
        $request->validate([
            'name' => 'required|unique:status_stores'
        ]);

        return response()->json(['message' => 'Valid Status Name'], 200);
    }
}
