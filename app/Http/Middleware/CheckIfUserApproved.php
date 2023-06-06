<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Http\Resources\UserResource;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckIfUserApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('app/http/middleware/CheckIfUserApproved:', ['new' => '...............................']);
        Log::info('app/http/middleware/CheckIfUserApproved:', ['auth()->check()' => auth()->check()]);
        Log::info('app/http/middleware/CheckIfUserApproved:', ['sanctum/csrf-cookie' => $request->is('sanctum/csrf-cookie')]);
        Log::info('app/http/middleware/CheckIfUserApproved:', ['register' => $request->is('register')]);
        Log::info('app/http/middleware/CheckIfUserApproved:', ['login' => $request->is('login')]);
        Log::info('app/http/middleware/CheckIfUserApproved:', ['logout' => $request->is('logout')]);
        Log::info('app/http/middleware/CheckIfUserApproved:', ['api/isRequestValid' => $request->is('api/isRequestValid')]);
        // Skip middleware for the sanctum/csrf-cookie register routes
        // there is no need to do this actually, but no harm!
        if ($request->is('sanctum/csrf-cookie') || $request->is('register')  || $request->is('logout')) {
            Log::info('app/http/middleware/CheckIfUserApproved:', ['Skip' => 'Skip']);
            return $next($request);
        }


        if(auth()->check()){
            if(auth()->user()->is_approved == 0) {
                Log::info('app/http/middleware/CheckIfUserApproved:', ['not_approved' => 'not_approved']);

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Inactive', 'user' => new UserResource(Auth::user())], 403);
                }

                return redirect()->route('login')->with('error', 'Your Account is not active yet, please contact Admin.');
            }
        }

        $exists = User::where('email', $request->email)->exists();
        Log::info('app/http/middleware/CheckIfUserApproved:', ['$request->email' => $request->email]);
        Log::info('app/http/middleware/CheckIfUserApproved:', ['!$exists' => !$exists]);
        if(!auth()->check() && !$exists && ($request->is('register') || $request->is('login'))){
            return $next($request);
        }

        $user = User::where('email', $request->email)->first();

        if(!auth()->check() && $user){
            if($user->is_approved == 0){
                Log::info('app/http/middleware/CheckIfUserApproved:', ['not_approved' => 'not_approved']);

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Inactive', 'user' => new UserResource($user)], 403);
                }

                return redirect()->route('login')->with('error', 'Your Account is not active yet, please contact Admin.');
            }
        }
        return $next($request);
    }

}
