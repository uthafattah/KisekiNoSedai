<?php

namespace App\Http\Controllers;

use App\Wishlist;
use Illuminate\Http\Request;
use App\Http\Resources\Wishlist as WishlistResource;
use App\Http\Resources\WishlistCollection as WishlistResourceCollection;

class WishlistController extends Controller
{
    public function index()
    {
        //return response()->json(['wishlist' => Wishlist::all()], 200);
        return new WishlistResourceCollection(Wishlist::paginate(5));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function userWishlist($id)
    {
        $wishlist = Wishlist::where('user_id', '=', "$id")->get();
        $merchandise_wishlist = [];
        foreach($wishlist as $wishlists){
            $merchandise_wishlist[] = new WishlistResource($wishlists);
        }
        return response()->json(['wishlist' => $merchandise_wishlist], 200);
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
