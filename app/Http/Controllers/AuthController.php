<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function __invoke()
    {
        return new UserResource(Auth::user());
    }

    public function isRequestValid(Request $request)
    {
          //
        return response()->json(['isRequestValid' => true, 'user' => new UserResource(Auth::user())], 200);
    }
}
