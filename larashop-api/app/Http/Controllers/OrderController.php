<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection as OrderResourceCollection;

class OrderController extends Controller
{
    public function index()
    {
        //return response()->json(['order' => Order::all()], 200);
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

    public function searchUserId($id)
    {
        $order = Order::where('user_id', 'LIKE', "$id")->paginate(10);
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
