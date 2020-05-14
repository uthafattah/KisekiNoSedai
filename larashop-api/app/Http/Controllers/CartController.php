<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Merchandise;
use App\Wishlist;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Cart as CartResource;
use App\Http\Resources\CartCollection as CartResourceCollection;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', '=', Auth::user()->id)->get();
        $cart = [];
        foreach($carts as $temp){
            $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $temp->merchandise_id)->first();
            $temp->status = $wishlist ? true : false;
            $cart[] = new CartResource($temp);
        }
        return response()->json(['cart' => $cart], 200);
    }

    public function store(Request $request)
    {
        $merchandise = Merchandise::where('id', $request->id)->first();

        $user_cart = Cart::select('*')
            ->where('user_id', '=', Auth::user()->id)
            ->where('merchandise_id', '=', $merchandise->id)
            ->first();

        if(!$user_cart) {
            $cart = new Cart([
                'user_id' => Auth::user()->id,
                'merchandise_id' => $merchandise->id,
                'quantity' => $request->quantity
            ]);
            $cart->save();
            $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $cart->merchandise_id)->first();
            $cart->status = $wishlist ? true : false;
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
