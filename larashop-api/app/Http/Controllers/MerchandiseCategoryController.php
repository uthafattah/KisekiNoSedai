<?php

namespace App\Http\Controllers;

use App\MerchandiseCategory;
use Illuminate\Http\Request;
use App\Http\Resources\MerchandiseCategory as MerchandiseCategoryResource;
use App\Http\Resources\MerchandiseCategoryCollection as MerchandiseCategoryResourceCollection;

class MerchandiseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(['merchandiseCategory' => MerchandiseCategory::all()], 200);
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
     * @param  \App\MerchandiseCategory  $merchandiseCategory
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $merchandiseCategory = MerchandiseCategory::where('name', 'LIKE', "%$param%")->paginate(10);
        return response()->json(['merchandiseCategory' => $merchandiseCategory], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MerchandiseCategory  $merchandiseCategory
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MerchandiseCategory  $merchandiseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MerchandiseCategory $merchandiseCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MerchandiseCategory  $merchandiseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MerchandiseCategory $merchandiseCategory)
    {
        //
    }
}
