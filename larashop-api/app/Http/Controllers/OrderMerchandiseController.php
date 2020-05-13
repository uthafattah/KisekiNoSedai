<?php

namespace App\Http\Controllers;

use App\OrderMerchandise;
use Illuminate\Http\Request;
use App\Http\Resources\OrderMerchandise as OrderMerchandiseResource;
use App\Http\Resources\OrderMerchandiseCollection as OrderMerchandiseResourceCollection;

class OrderMerchandiseController extends Controller
{
    public function index()
    {
        //return response()->json(['order_merchandise' => OrderMerchandise::all()], 200);
        return new OrderMerchandiseResourceCollection(OrderMerchandise::paginate(5));
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
