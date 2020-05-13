<?php

namespace App\Http\Controllers;

use App\MerchandiseCategory;
use App\Merchandise;
use Illuminate\Http\Request;
use App\Http\Resources\Merchandise as MerchandiseResource;
use App\Http\Resources\MerchandiseCategory as MerchandiseCategoryResource;
use App\Http\Resources\MerchandiseCategoryCollection as MerchandiseCategoryResourceCollection;

class MerchandiseCategoryController extends Controller
{
    public function index()
    {
        //return response()->json(['merchandise_category' => MerchandiseCategory::all()], 200);
        return new MerchandiseCategoryCollection(MerchandiseCategory::paginate(5));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function find($id)
    {
        $merchandises = MerchandiseCategory::select('merchandise_id')
            ->where('category_id', '=', "$id")
            ->get();   

        $merchandise = [];
        foreach($merchandises as $merch){
            $merchandise[] = Merchandise::where('id', '=', $merch->merchandise_id)->first();
        }
        return response()->json(['merchandise' => $merchandise], 200);
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
