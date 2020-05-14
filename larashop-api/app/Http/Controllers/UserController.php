<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection as UserResourceCollection;
use App\User;
Use App\Role;
Use App\Store;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'users' => new UserResourceCollection(User::orderBy($sortBy, $orderBy)->paginate($per_page)),
            'roles' => Role::pluck('name')->all()
        ], 200);
    }

    public function store(Request $request)
    {
        $role = Role::where('name', $request->role)->first();
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' =>  $request->address,
            'avatar' => 'avatars/no_avatar.png'
        ]);
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResource($user)], 200);
    }

    public function show($id)
    {
        $user = User::where('name', 'LIKE', "%$id%")->paginate(10);
        return response()->json(['user' => new UserResourceCollection($user)], 200);
    }

    public function search($id)
    {
        $user = User::where('id', '=', "$id")->get();
        return response()->json(['user' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $role = Role::where('name', $request->role)->first();
        $user = User::find($id);
        $user->name = $request->name;
        $user->role()->dissociate($user->role);
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResource($user)], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return response()->json(['user' => $user], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Str::random(80);
            Auth::User()->api_token = $token;
            Auth::User()->save();
            $user = Auth::User();
            $store = Store::where('user_id', '=', Auth::User()->id)->first();
            return response()->json(['user' => $user, 'token' => $token, 'store' => $store], 200);
        }

        return response()->json(['status' => 'Email or Password is Wrong'], 403);
    }

    public function verify(Request $request)
    {
        return $request->User()->only('name', 'email');
    }

    public function loggedUser()
    {
        $user = Auth::user();
        $store = Store::where('user_id', '=', Auth::User()->id)->first(); 
        if($user) return response()->json(['user' => $user, 'store' => $store], 200);
        return response()->json(['message' => 'You must LoggedIn'], 403);
    }

    public function register(Request $request)
    {
        $role = Role::where('name', 'Costumer')->first();
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResource($user)], 200);
    }

    public function changeRole(Request $request)
    {
        $user = User::find($request->user);
        $loggedInUser = $request->user();
        if ($user->id === $loggedInUser->id) {
            return response()->json(['user' => new UserResource($loggedInUser)], 422);
        }
        $role = Role::where('name', $request->role)->first();
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResource($user)], 200);
    }

    public function verifyEmail(Request $request) 
    {
        $request->validate([
            'email' => 'required|email|unique:users'
        ]);

        return response()->json(['message' => 'Valid Email'], 200);
    }
}
