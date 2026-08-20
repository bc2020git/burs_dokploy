<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('aday')->check() || Auth::guard('bursiyer')->check()) {
            return $next($request);
        }

        session()->flash('error', 'Lütfen giriş yapınız');
        return redirect()->route('student.active.login');
    }
} 