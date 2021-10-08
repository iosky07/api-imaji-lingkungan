<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token');
        if(is_null($token)){
            return response()->json([
                'success' => 0,
                'message' => 'Token Unavailable'
            ], 401);
        }

        $user = User::where('remember_token', $token)->first();

        if(is_null($user)){
            return response()->json([
                'success' => 0,
                'message' => 'Token Invalid'
            ], 401);
        }

        return $next($request);
    }
}
