<?php

namespace App\Http\Controllers;

use App\StatusCategory;
use Illuminate\Http\Request;
use App\Http\Resources\StatusCategory as StatusCategoryResource;
use App\Http\Resources\StatusCategoryCollection as StatusCategoryResourceCollection;

class StatusCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(['statusCategory' => StatusCategory::all()], 200);
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
     * @param  \App\StatusCategory  $statusCategory
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $statusCategory = StatusCategory::where('name', 'LIKE', "%$param%")->paginate(10);
        return response()->json(['statusCategory' => $statusCategory], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatusCategory  $statusCategory
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StatusCategory  $statusCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatusCategory $statusCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatusCategory  $statusCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusCategory $statusCategory)
    {
        //
    }
}
