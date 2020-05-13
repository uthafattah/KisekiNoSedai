<?php

namespace App\Http\Controllers;

use App\StatusOrder;
use Illuminate\Http\Request;
use App\Http\Resources\StatusOrder as StatusOrderResource;
use App\Http\Resources\StatusOrderCollection as StatusOrderResourceCollection;

class StatusOrderController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'status_orders' => new StatusOrderResourceCollection(StatusOrder::orderBy($sortBy, $orderBy)->paginate($per_page))
        ], 200);
    }

    public function store(Request $request)
    {
        $status_order = new StatusOrder([
            'name' => $request->name,
            'slug' => \Str::slug($request->name, '-'),
        ]);
        $status_order->save();
        return response()->json(['status_order' => new StatusOrderResource($status_order)], 200);
    }

    public function show($id)
    {
        $status_order = StatusOrder::where('name', 'LIKE', "%$id%")->paginate();
        return response()->json(['status_order' => new StatusOrderResourceCollection($status_order)], 200);
    }

    public function update(Request $request, $id)
    {
        $status_order = StatusOrder::find($id);
        $status_order->name = $request->name;
        $status_order->slug = \Str::slug($request->name, '-');
        $status_order->save();
        return response()->json(['status_order' => new StatusOrderResource($status_order)], 200);
    }
    
    public function destroy($id)
    {
        $status_order = StatusOrder::find($id)->delete();
        return response()->json(['status_order' => $status_order], 200);
    }

    public function verifyStatus(Request $request) 
    {
        $request->validate([
            'name' => 'required|unique:status_orders'
        ]);

        return response()->json(['message' => 'Valid Status Name'], 200);
    }
}
