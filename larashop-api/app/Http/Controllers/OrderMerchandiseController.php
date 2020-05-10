<?php

namespace App\Http\Controllers;

use App\OrderMerchandise;
use Illuminate\Http\Request;
use App\Http\Resources\OrderMerchandise as OrderMerchandiseResource;
use App\Http\Resources\OrderMerchandiseCollection as OrderMerchandiseResourceCollection;

class OrderMerchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(['orderMerchandise' => OrderMerchandise::all()], 200);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = $request->per_page ? $request->per_page : 10;
		$sortBy = $request->sort_by ? $request->sort_by : 'id';
		$orderBy = $request->order_by ? $request->order_by : 'asc';
		return response()->json([
			'roles' => Role::orderBy($sort_by,$order_by)->paginate($per_page)
		]. 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderMerchandise  $orderMerchandise
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $orderMerchandise = OrderMerchandise::where('name', 'LIKE', "%$param%")->paginate(10);
        return response()->json(['orderMerchandise' => $orderMerchandise], 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderMerchandise  $orderMerchandise
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderMerchandise  $orderMerchandise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderMerchandise $orderMerchandise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderMerchandise  $orderMerchandise
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderMerchandise $orderMerchandise)
    {
        //
    }
}
