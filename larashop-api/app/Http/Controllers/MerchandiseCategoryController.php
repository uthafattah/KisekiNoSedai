<?php

namespace App\Http\Controllers;

use App\MerchandiseCategory;
use App\Merchandise;
use App\Wishlist;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Merchandise as MerchandiseResource;
use App\Http\Resources\MerchandiseCategory as MerchandiseCategoryResource;
use App\Http\Resources\MerchandiseCategoryCollection as MerchandiseCategoryResourceCollection;

class MerchandiseCategoryController extends Controller
{
    public function index()
    {
        return new MerchandiseCategoryCollection(MerchandiseCategory::paginate(10));
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
        foreach($merchandises as $temp){
            $temp2 = Merchandise::where('id', '=', $temp->merchandise_id)->first();
            if(Auth::user()) {
                $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $temp2->id)->first();
                $temp2->status = $wishlist ? true : false;
            } else {
                $temp2->status = false;
            }
            $merchandise[] = new MerchandiseResource($temp2);
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
