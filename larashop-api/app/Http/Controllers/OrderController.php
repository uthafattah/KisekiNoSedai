<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderMerchandise;
Use App\StatusOrder;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection as OrderResourceCollection;
use App\Http\Resources\OrderMerchandise as OrderMerchandiseResource;

class OrderController extends Controller
{
    public function index()
    {
        return new OrderResourceCollection(Order::paginate(5));
    }

    public function store(Request $request)
    {
        $order = new Order([
            'user_id' => Auth::user()->id,
            'total_price' => $request->total_price,
            'invoice_number' => "INV/" . strtoupper(str_random(2)) . "/" . strtoupper(str_random(3)) . "/" . rand(100000, 999999),
            'status_order_id' => 1,
            'payment_id' => 1
        ]);
        $order->save();
        //$order = new OrderResource($order);

        $merchandises = $request->checked;
        $order_merchandise = [];
        foreach($merchandises as $merchandise){
            $temp = new OrderMerchandise([
                'order_id' => $order->id, 
                'merchandise_id' => $merchandise['merchandise_id'], 
                'quantity' => $merchandise['quantity'], 
                'note' => ''
            ]);
            $temp->save();
            $order_merchandise[] = $temp;
        }
        return response()->json(['order' => $order, 'order_merchandise' => $order_merchandise], 200);
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
    
    public function storeOrder(Request $request)
    {
        /*$store = Store::where('user_id', '=', Auth::User()->id)->first();
        $orders = Order::where('store_id', '=', $store->id)->get();
        $order = [];
        foreach($orders as $temp){
            $order[] = new OrderResource($temp);
        }
        return response()->json(['order' => $order], 200);*/

        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'order' => new OrderResourceCollection(Order::where('user_id', '=', Auth::user()->id)->orderBy($sortBy, $orderBy)->paginate($per_page)),
            'status_order' => StatusOrder::pluck('name')->all()
        ], 200);
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
