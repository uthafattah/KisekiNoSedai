<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection as UserResourceCollection;
use App\User;
Use App\Role;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(['user' => User::all()], 200);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
    public function index()
    {
        //return response()->json(['user' => User::all()], 200);
        //return new UserResourceCollection(User::paginate(10));
		
		$per_page = $request->per_page ? $request->per_page : 10;
		$sortBy = $request->sort_by ? $request->sort_by : 'id';
		$orderBy = $request->order_by ? $request->order_by : 'asc';
		return response()->json([
			'users' => new UserResourceCollection(User::orderBy($sortBy, $orderBy)->paginate($per_page)),
			'roles' => Role::orderBy($sort_by,$order_by)->paginate($per_page)
		]. 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::where('name', $request->role)->first();
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResourceCollection($user)], 200);
    }
	
	 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($param)
    {
        $user = User::where('name', 'LIKE', "%$param%")->paginate();
        return response()->json(['user' => $user], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $user = User::where('name', 'LIKE', "%$param%")->paginate();
        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::where('name', $request->role)->first();
        $user = User::find($id);
        $user->name = $request->name;
        $user->role()->dissociate($user->role);
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResourceCollection($user)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return response()->json(['user' => $user], 200);
    }
	
	public function deleteAll(Request $request)
    {
        User::whereIn('id', $request->users)->delete();
        $selected = [];
        return response()->json(['message', 'Records Deleted Successfully'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Str::random(80);
            Auth::User()->api_token = $token;
            Auth::User()->save();
            $admin = Auth::User()->isAdmin();
            return response()->json(['token' => $token, 'isAdmin' => $admin], 200);
        }

        return response()->json(['status' => 'Email or Password is Wrong'], 403);
    }

    public function verify(Request $request)
    {
        return $request->User()->only('name', 'email');
    }

    public function changeRole(Request $request)
    {
        $user = User::find($request->user);
        $loggedInUser = $request->user();
        if ($user->id === $loggedInUser->id) {
            return response()->json(['user' => new UserResourceCollection($loggedInUser)], 422);
        }
        $role = Role::where('name', $request->role)->first();
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResourceCollection($user)], 200);
    }

    public function verifyEmail(Request $request) 
    {
        $request->validate([
            'email' => 'required|email|unique:users'
        ]);

        return response()->json(['message' => 'Valid Email'], 200);
    }
}
