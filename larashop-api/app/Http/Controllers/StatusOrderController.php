<?php

namespace App\Http\Controllers;

use App\StatusOrder;
use Illuminate\Http\Request;
use App\Http\Resources\StatusOrder as StatusOrderResource;
use App\Http\Resources\StatusOrderCollection as StatusOrderResourceCollection;

class StatusOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(['statusOrder' => StatusOrder::all()], 200);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new StatusOrderResourceCollection(StatusOrder::paginate(10));
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
     * @param  \App\StatusOrder  $statusOrder
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $statusOrder = StatusOrder::where('name', 'LIKE', "%$param%")->paginate(10);
        return response()->json(['statusOrder' => $statusOrder], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatusOrder  $statusOrder
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StatusOrder  $statusOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatusOrder $statusOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatusOrder  $statusOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusOrder $statusOrder)
    {
        //
    }
}
