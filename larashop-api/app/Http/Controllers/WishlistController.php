<?php

namespace App\Http\Controllers;

use App\Wishlist;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Wishlist as WishlistResource;
use App\Http\Resources\WishlistCollection as WishlistResourceCollection;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', '=', Auth::User()->id)->get();
        $merchandise_wishlist = [];
        foreach($wishlists as $wish){
            $wish->status = true;
            $merchandise_wishlist[] = new WishlistResource($wish);
        }
        return response()->json(['wishlist' => $merchandise_wishlist], 200);
    }

    public function store(Request $request)
    {
        $status = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $request->merchandise_id)->first();
        if(!$status) {
            $wishlist = new Wishlist([
                'user_id' => Auth::user()->id,
                'merchandise_id' => $request->merchandise_id,
            ]);
            $wishlist->save();
            return response()->json(['wishlist' => new WishlistResource($wishlist)], 200);
        }
    }

    public function show($id)
    {
        //
    }

    public function status($user_id, $merchandise_id)
    {
        $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', $merchandise_id)->first();
        if($wishlist) return response()->json(['status' => true, 'wishlist' => $wishlist], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->where('merchandise_id', '=', "$id")->first();
        $status = Wishlist::find($wishlist->id)->delete();
        return response()->json(['wishlist' => new WishlistResource($wishlist), 'status' => $status], 200);
    }
}
