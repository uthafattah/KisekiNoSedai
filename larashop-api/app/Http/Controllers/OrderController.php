<?php

namespace App\Http\Controllers;

use App\Order;
Use App\StatusOrder;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection as OrderResourceCollection;

class OrderController extends Controller
{
    public function index()
    {
        return new OrderResourceCollection(Order::paginate(5));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $order = Order::where('id', 'LIKE', "%$id%")->paginate();
        return response()->json(['order' => $order], 200);
    }

    public function userOrder()
    {
        $orders = Order::where('user_id', '=', Auth::user()->id)->get();
        $order = [];
        foreach($orders as $temp){
            $order[] = new OrderResource($temp);
        }
        return response()->json(['order' => $order], 200);
    }
    
    public function storeOrder($id)
    {
        $store = Store::where('user_id', '=', Auth::User()->id)->first();
        $orders = Order::where('store_id', '=', $store->id)->get();
        $order = [];
        foreach($orders as $temp){
            $order[] = new OrderResource($temp);
        }
        return response()->json(['order' => $order], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
	
	public function order($id)
    {
        $order = Order::where('id', 'LIKE', "%$id%")->paginate();
        return response()->json(['order' => $order], 200);
    }
	
	public function checkout($id)
    {
        $order = Order::where('id', 'LIKE', "%$id%")->paginate();
        return response()->json(['order' => $order], 200);
    }
	
	public function cancelOrder($id)
    {
        $order = Order::where('id', 'LIKE', "%$id%")->paginate();
        return response()->json(['order' => $order], 200);
    }
}
