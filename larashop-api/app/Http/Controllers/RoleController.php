<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleCollection as RoleResourceCollection;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'roles' => new RoleResourceCollection(Role::orderBy($sortBy, $orderBy)->paginate($per_page))
        ], 200);
    }

    public function store(Request $request)
    {
        $role = new Role([
            'name' => $request->name,
            'slug' => \Str::slug($request->name, '-'),
        ]);
        $role->save();
        return response()->json(['role' => new RoleResource($role)], 200);
    }

    public function show($id)
    {
        $role = Role::where('name', 'LIKE', "%$id%")->paginate(10);
        return response()->json(['role' =>  new RoleResourceCollection($role)], 200);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->slug = \Str::slug($request->name, '-');
        $role->save();
        return response()->json(['role' => new RoleResource($role)], 200);
    }

    public function destroy($id)
    {
        $role = Role::find($id)->delete();
        return response()->json(['role' => $role], 200);
    }

    public function verify(Request $request)
    {
        return $request->Role()->only('name');
    }

    public function verifyRole(Request $request) 
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        return response()->json(['message' => 'Valid Role Name'], 200);
    }
}
