<?php

namespace App\Http\Controllers;

use App\OrderMerchandise;
use App\Store;
use App\Merchandise;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\OrderMerchandise as OrderMerchandiseResource;
use App\Http\Resources\OrderMerchandiseCollection as OrderMerchandiseResourceCollection;

class OrderMerchandiseController extends Controller
{
    public function index()
    {
        return new OrderMerchandiseResourceCollection(OrderMerchandise::paginate(10));
    }

    public function store(Request $request)
    {
        //
    }

    public function userOrderMerchandise($id)
    {
        $orders = OrderMerchandise::where('order_id', '=', $id)->get();

        $order_merchandise = [];
        foreach($orders as $temp){
            $order_merchandise[] = new OrderMerchandiseResource($temp);
        }
        return response()->json(['order_merchandise' => $order_merchandise], 200);
    }    

    public function storeOrderMerchandise($id)
    {
        $orders = OrderMerchandise::where('order_id', '=', $id)->get();

        $order_merchandise = [];
        foreach($orders as $temp){
            $order_merchandise[] = new OrderMerchandiseResource($temp);
        }
        return response()->json(['order_merchandise' => $order_merchandise], 200);
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
