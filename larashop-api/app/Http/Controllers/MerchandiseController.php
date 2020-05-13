<?php

namespace App\Http\Controllers;

use App\Merchandise;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Merchandise as MerchandiseResource;
use App\Http\Resources\MerchandiseCollection as MerchandiseResourceCollection;

class MerchandiseController extends Controller
{
    public function all()
    {
        return response()->json(['merchandise' => Merchandise::all()], 200);
        //return new MerchandiseResourceCollection(Merchandise::all());
    }

    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'merchandises' => new MerchandiseResourceCollection(Merchandise::orderBy($sortBy, $orderBy)->paginate($per_page)),
            'categories' => Category::pluck('name')->all()
        ], 200);
    }

    public function top($count)
    {
        $merchandise = Merchandise::select('*')
            ->orderBy('view_count', 'DESC')
            ->limit($count)
            ->get();        
        return response()->json(['merchandise' => $merchandise], 200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $merchandise = Merchandise::where('id', 'LIKE', "%$id%")->paginate();
        return response()->json(['merchandise' => $merchandise], 200);
    }

    public function find($id)
    {
        $merchandise = Merchandise::where('name', 'LIKE', "%$id%")->get();  
        return response()->json(['merchandise' => $merchandise], 200);
    }
    
    public function search($id)
    {
        $merchandise = Merchandise::where('id', '=', "$id")->first();
        return response()->json(['merchandise' => new MerchandiseResource($merchandise)], 200);
    }

    public function userMerchandise($id)
    {
        $merchandise = Merchandise::where('store_id', '=', "$id")->get();
        $merchandise_store = [];
        foreach($merchandise as $merchandises){
            $merchandise_store[] = new MerchandiseResource($merchandises);
        }
        return response()->json(['merchandise' => $merchandise_store], 200);
    }

    public function storeMerchandise(Request $request, $id)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'merchandises' => new MerchandiseResourceCollection(Merchandise::where('store_id', '=', "$id")->orderBy($sortBy, $orderBy)->paginate($per_page)),
            'categories' => Category::pluck('name')->all()
        ], 200);
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
