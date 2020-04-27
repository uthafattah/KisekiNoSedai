<?php

namespace App\Http\Controllers;

use App\StatusStore;
use Illuminate\Http\Request;
use App\Http\Resources\StatusStore as StatusStoreResource;
use App\Http\Resources\StatusStoreCollection as StatusStoreResourceCollection;

class StatusStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(['statusStore' => StatusStore::all()], 200);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new StatusStoreResourceCollection(StatusStore::paginate(10));
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
     * @param  \App\StatusStore  $statusStore
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $statusStore = StatusStore::where('name', 'LIKE', "%$param%")->paginate(10);
        return response()->json(['statusStore' => $statusStore], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatusStore  $statusStore
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StatusStore  $statusStore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatusStore $statusStore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatusStore  $statusStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusStore $statusStore)
    {
        //
    }
}
