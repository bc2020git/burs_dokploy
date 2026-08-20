<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateStudent
{
    public function handle($request, Closure $next, $guard = 'student')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('student.login'); // Öğrenci login rotasına yönlendirme yapın
        }

        return $next($request);
    }
}
