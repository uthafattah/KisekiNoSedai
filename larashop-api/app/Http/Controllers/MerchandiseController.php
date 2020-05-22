<?php

namespace App\Http\Controllers;

use App\Merchandise;
use App\Store;
use App\Category;
use App\Wishlist;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Merchandise as MerchandiseResource;
use App\Http\Resources\MerchandiseCollection as MerchandiseResourceCollection;

class MerchandiseController extends Controller
{
    public function all()
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'merchandises' => new MerchandiseResourceCollection(Merchandise::orderBy($sortBy, $orderBy)->paginate($per_page)),
            'categories' => Category::pluck('name')->all()
        ], 200);
    }

    public function index(Request $request)
    {
        $store = Store::where('user_id', '=', Auth::User()->id)->first();
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'merchandises' => new MerchandiseResourceCollection(Merchandise::where('store_id', '=', $store->id)->orderBy($sortBy, $orderBy)->paginate($per_page)),
            'categories' => Category::pluck('name')->all()
        ], 200);
    }

    public function top($count)
    {
        $merchandises = Merchandise::select('*')
            ->orderBy('view_count', 'DESC')
            ->limit($count)
            ->get();        
        $merchandise = [];
        foreach($merchandises as $temp){
            if(Auth::user()) {
                $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $temp->id)->first();
                $temp->status = $wishlist ? true : false;
            } else {
                $temp->status = false;
            }
            $merchandise[] = new MerchandiseResource($temp);
        }
        return response()->json(['merchandise' => $merchandise], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $store = Store::where('user_id', '=', Auth::User()->id)->first();
        $merchandise = Merchandise::where('name', 'LIKE', "%$id%")->where('store_id', '=', $store->id)->paginate(10);
        return response()->json(['merchandise' => new MerchandiseResourceCollection($merchandise)], 200);
    }

    public function find($id)
    {
        $merchandises = Merchandise::where('name', 'LIKE', "%$id%")->get(); 
        $merchandise = [];
        foreach($merchandises as $temp){
            if(Auth::user()) {
                $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $temp->id)->first();
                $temp->status = $wishlist ? true : false;
            } else {
                $temp->status = false;
            }
            $merchandise[] = new MerchandiseResource($temp);
        }
        return response()->json(['merchandise' => $merchandise], 200);
    }
    
    public function search($id)
    {
        $merchandise = Merchandise::where('id', '=', "$id")->first();
        if(Auth::user()) {
            $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $temp->id)->first();
            $merchandise->status = $wishlist ? true : false;
        } else {
            $merchandise->status = false;
        }
        return response()->json(['merchandise' => new MerchandiseResource($merchandise)], 200);
    }

    public function storeMerchandise(Request $request, $id)
    {
        $merchandises = Merchandise::where('store_id', '=', "$id")->get();
        $merchandise_store = [];
        foreach($merchandises as $temp){
            if(Auth::user()) {
                $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $temp->id)->first();
                $temp->status = $wishlist ? true : false;
            } else {
                $temp->status = false;
            }
            $merchandise_store[] = new MerchandiseResource($temp);
        }
        return response()->json(['merchandise' => $merchandise_store], 200);
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
