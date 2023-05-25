<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Admin;
use App\Models\User;
use App\Models\RegularUser;
use App\Http\Resources\UserResource;
use App\Http\Resources\RegularUserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        if(!($adminExists = Admin::where('user_id', Auth::user()->id )->exists())){
            return response()->json(["message" => "You are not an admin"], 401);
        }
        $users = User::all();
        return UserResource::collection($users);

    }

    public function approveAsRegularUser(Request $request, string $id)
    {
        $adminExists = Admin::where('user_id', Auth::user()->id )->exists();
        if(!$adminExists){
            return response()->json(["message" => "You are not an admin"], 401);
        }
        $user = User::where('email', $request->input('email') )->first();
        if(!$user){
            return response()->json(["message" => "User is not registered"], 409);
        }
        if(!$user->$regularUser) {
            $regularUserCreate = RegularUser::create([
                "user_id" => $user->id,
            ]);
        }
        $userUpdate = User::where('id', $user->id)
            ->update([
                'is_approved'=> 1,
        ]);
        // or
        // $user->is_approved=true;
        // $user->save();
        if($userUpdate->regularUser && $userUpdate) {
            return new UserResource($user);
        }
        return response()->json(["message" => "Something went wrong"], 409);
    }
}
