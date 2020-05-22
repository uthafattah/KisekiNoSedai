<?php

namespace App\Http\Controllers;

use App\Follow;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Follow as FollowResource;
use App\Http\Resources\FollowCollection as FollowResourceCollection;

class FollowController extends Controller
{
    public function index()
    {
        $follows = Follow::where('user_id', '=', Auth::User()->id)->get();
        $store_follow = [];
        foreach($follows as $follow){
            $follow->status = true;
            $store_follow[] = new FollowResource($follow);
        }
        return response()->json(['follow' => $store_follow], 200);
    }

    public function store(Request $request)
    {
        $status = Follow::where('user_id', '=', Auth::user()->id)->where('store_id', '=', $request->store_id)->first();
        if(!$status) {
            $follow = new Follow([
                'user_id' => Auth::user()->id,
                'store_id' => $request->store_id,
            ]);
            $follow->save();
            return response()->json(['follow' => new FollowResource($follow)], 200);
        }
    }

    public function show(Follow $follow)
    {
        //
    }

    public function status($user_id, $store_id)
    {
        $follow = Follow::where('user_id', '=', Auth::user()->id)->where('store_id', '=', $store_id)->first();
        if($follow) return response()->json(['status' => true, 'follow' => $follow], 200);
    }

    public function update(Request $request, Follow $follow)
    {
        //
    }

    public function destroy($id)
    {
        $follow = Follow::where('user_id', '=', Auth::user()->id)->where('store_id', '=', "$id")->first();
        $status = Follow::find($follow->id)->delete();
        return response()->json(['follow' => new FollowResource($follow), 'status' => $status], 200);
    }
}
