<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Merchandise;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Cart as CartResource;
use App\Http\Resources\CartCollection as CartResourceCollection;

class CartController extends Controller
{
    public function index()
    {
        //return response()->json(['cart' => Cart::all()], 200);
        return new CartResourceCollection(Cart::paginate(5));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $merchandise = Merchandise::where('id', $request->id)->first();

        $user_cart = Cart::select('*')
            ->where('user_id', '=', $user_id)
            ->where('merchandise_id', '=', $merchandise->id)
            ->first();

        if(!$user_cart) {
            $cart = new Cart([
                'user_id' => $user_id,
                'merchandise_id' => $merchandise->id,
                'quantity' => $request->quantity
            ]);
            $cart->save();
            return response()->json(['cart' => new CartResource($cart)], 200);
        } else {
            $user_cart->quantity += $request->quantity;
            $user_cart->save();
            return response()->json(['cart' => new CartResource($user_cart)], 200);
        }
    }

    public function show($id)
    {
        $cart = Cart::where('id', '=', "$id")->first();
        return response()->json(['cart' => $cart], 200);
    }

    public function userCart($id)
    {
        $cart = Cart::where('user_id', '=', "$id")->get();
        $merchandise_cart = [];
        foreach($cart as $carts){
            $merchandise_cart[] = new CartResource($carts);
        }
        return response()->json(['cart' => $merchandise_cart], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function addQuantity($id)
    {
        $cart = Cart::find($id);
        $cart->quantity++;
        $cart->save();
        return response()->json(['cart' => new CartResource($cart)], 200);
    }

    public function subtractQuantity($id)
    {
        $cart = Cart::find($id);
        $cart->quantity--;
        $cart->save();
        return response()->json(['cart' => new CartResource($cart)], 200);
    }
    
    public function destroy($id)
    {
        $cart = Cart::where('id', '=', "$id")->first();
        $status = Cart::find($id)->delete();
        return response()->json(['cart' => $cart, 'status' => $status], 200);
    }
}
