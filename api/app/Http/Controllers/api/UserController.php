<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Resources\AdminResource;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function show_me(Request $request)
    {
        return new UserResource($request->user());
    }

    public function storeUser(StoreUserRequest $request)
    {
        $newUser = Admin::create($request->validated());
        $newUser->password = Hash::make($request['password']);
        $newUser->save();
        return new AdminResource($newUser);
    }

    public function updateUser(StoreUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    
    public function updateAdmin(UpdateAdminRequest $request, Admin $user)
    {
        $user->update($request->validated());
        return new AdminResource($user);
    }

    public function removeAdmin(Admin $user)
    {
        $user = Admin::findOrFail($user->id);
        $user->delete();
    }

    //Soft delete, it will stay in the DB
    public function destroyUser(User $user)
    {
        $user->delete();
        return new UserResource($user);
    }
}