<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() ) {
            $user = Auth::user();
            $id = $user->getAuthIdentifier();
            $user = User::where('id',$id)->first();
            if ($user->role_id == 0 && !$request->is('home') ) {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
