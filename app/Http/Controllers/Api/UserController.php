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
        //TODO: use policies here https://laravel.com/docs/10.x/authorization#creating-policies
        if(!($adminExists = Admin::where('user_id', Auth::user()->id )->exists())){
            return response()->json(["errors" => ["Unauthorized" => "You are not an admin"]], 401);
        }
        $users = User::all();
        return UserResource::collection($users);

    }

    public function setUserTypeAndApproval(Request $request, string $id)
    {
        $adminExists = Admin::where('user_id', Auth::user()->id )->exists();
        if(!$adminExists){
            return response()->json(["errors" => ["Unauthorized" => "You are not an admin"]], 401);
        }
        if($request->userType){
            if(strcmp($request->userType, 'ADMIN') !== 0 && strcmp($request->userType, 'REGULAR_USER') !== 0 && strcmp($request->userType, 'NONE') !== 0){
                return response()->json(["errors" => ["Bad Request" => "Please provide a suitable userType(role) for the user"]], 400);
            }
        }
        if(!$id){
            return response()->json(["errors" => ["Bad Request" => "Please provide an id for the user"]], 400);
        }

        $user = User::where('id', $id )->first();
        if(!$user){
            return response()->json(["errors" => ["message" => "User is not registered"]], 409);
        }
        if(strcmp($request->userType, 'ADMIN') === 0) {
            if(strcmp($user->userType, 'REGULAR_USER') === 0) {
                return response()->json(["errors" => ["message" => "User user Already has a role, consider deactivating user or register user with different email"]], 409);
            }
            if(strcmp($user->userType, 'ADMIN') !== 0) {
                $adminCreate = Admin::create([
                    "user_id" => $user->id,
                ]);
            }
        }
        if(strcmp($request->userType, 'REGULAR_USER') === 0) {
            if(strcmp($user->userType, 'ADMIN') === 0) {
                return response()->json(["errors" => ["message" => "User user Already has a role, consider deactivating user or register user with different email"]], 409);
            }
            if(strcmp($user->userType, 'REGULAR_USER') !== 0) {
                $adminCreate = RegularUser::create([
                    "user_id" => $user->id,
                ]);
            }
        }
        // if userType in request is NONE, then keep current userType, if requester can just send isApproved=false
        $userUpdate = User::where('id', $user->id)
            ->update([
                'is_approved'=> $request->isApproved,
        ]);
        // or
        // $user->is_approved= $request->isApproved;
        // $user->save();
        if($userUpdate) {
            return new UserResource($user);
        }
        return response()->json(["errors" => ["Something went wrong"]], 409);
    }
}
