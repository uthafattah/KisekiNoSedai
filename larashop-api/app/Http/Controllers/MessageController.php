<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use App\Store;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Message as MessageResource;
use App\Http\Resources\MessageCollection as MessageResourceCollection;

class MessageController extends Controller
{
    public function index()
    {
        return new MessageResourceCollection(Message::paginate(10));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function userToStore()
    {
        $messages = Message::select('store_id')
            ->where('user_id', '=', Auth::User()->id)
            ->orderBy('created_at', 'DESC')
            ->distinct()
            ->get();     

        $user_chat = [];
        foreach($messages as $message){
            $store = Store::where('id', '=', "$message->store_id")->first();
            $user_chat[] = [
                'store_id' => $store->id,
                'name' => $store->name,
                'logo' => $store->logo,
            ];
        }
        return response()->json(['user_chat' => $user_chat], 200);
    }

    public function storeToUser()
    {
        $store = Store::where('user_id', '=', Auth::User()->id)->first();
        $messages = Message::select('user_id')
            ->where('store_id', '=', $store->id)
            ->orderBy('created_at', 'DESC')
            ->distinct()
            ->get();     
        $store_chat = [];
        foreach($messages as $message){
            $user = User::where('id', '=', "$message->user_id")->first();
            $store_chat[] = [
                'user_id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
            ];
        }
        return response()->json(['store_chat' => $store_chat], 200);
    }

    public function storeMessages($id)
    {
        $store = Store::where('user_id', '=', Auth::User()->id)->first();
        $messages = Message::select('*')
            ->where('store_id', '=', $store->id)
            ->where('user_id', '=', $id)
            ->orderBy('created_at', 'ASC')
            ->get();        
        $message = [];
        foreach($messages as $msg){
            $message[] = new MessageResource($msg);
        }
        return response()->json(['message' => $message], 200);
    }
    
    public function userMessages($id)
    {
        $messages = Message::select('*')
            ->where('user_id', '=', Auth::user()->id)
            ->where('store_id', '=', $id)
            ->orderBy('created_at', 'ASC')
            ->get();        
        $message = [];
        foreach($messages as $msg){
            $message[] = new MessageResource($msg);
        }
        return response()->json(['message' => $message], 200);
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
