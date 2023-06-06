<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class TokenController extends Controller
{
  public function __invoke(Request $request)
  {
    // // Log an informational message
    // Log::info('$request->email', ['id' => $request->email]);

    // // Log a warning message
    // Log::warning('This is a warning message');

    // // Log an error message
    // Log::error('This is an error message');
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
      'device_name' => 'required',
    ])->validate();

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
      ]);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json(['token' => $token], 200);
  }
}
