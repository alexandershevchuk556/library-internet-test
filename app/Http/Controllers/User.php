<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(UserRequest $request)
    {
        $request['password'] = Hash::make($request['password']);
        $user = UserModel::create($request->validated());
        return $user;
    }

    public function show($id)
    {
        return $user = UserModel::findOrFail($id);
    }

    public function update(UserRequest $request, $id)
    {
        $user = UserModel::findOrFail($id);
        $user->fill($request->except(['id']));
        $user->save();
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        if($user->delete()) return response(null, 204);
    }
}
