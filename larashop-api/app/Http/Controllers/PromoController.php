<?php

namespace App\Http\Controllers;

use App\Promo;
use Illuminate\Http\Request;
use App\Http\Resources\Promo as PromoResource;
use App\Http\Resources\PromoCollection as PromoResourceCollection;

class PromoController extends Controller
{
    public function all()
    {
        return response()->json(['promos' => Promo::all()], 200);
    }

    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'promos' => new PromoResourceCollection(Promo::orderBy($sortBy, $orderBy)->paginate($per_page))
        ], 200);
    }

    public function store(Request $request)
    {
        $promo = new Promo([
            'name' => $request->name,
            'promo_code' => $request->promo_code,
            'description' =>$request->description,
        ]);
        $promo->save();
        return response()->json(['promo' => new PromoResource($promo)], 200);
    }

    public function show($id)
    {
        $promo = Promo::where('name', 'LIKE', "%$id%")->paginate(10);
        return response()->json(['promo' => new PromoResourceCollection($promo)], 200);
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        $promo->name = $request->name;
        $promo->promo_code = $request->promo_code;
        $promo->description = $request->description;
        $promo->save();
        return response()->json(['promo' => new PromoResource($promo)], 200);
    }

    public function destroy($id)
    {
        $promo = Promo::find($id)->delete();
        return response()->json(['promo' => $promo], 200);
    }

    public function verifyPromo(Request $request) 
    {
        $request->validate([
            'promo_code' => 'required|unique:promos'
        ]);

        return response()->json(['message' => 'Valid Promo Code'], 200);
    }

    public function checkPromo($code) 
    {
        $promo = Promo::where('promo_code', '=', "$code")->first();
        return response()->json(['promo' => new PromoResource($promo)], 200);
    }
}
