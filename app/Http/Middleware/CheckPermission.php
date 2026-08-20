<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            return $this->unauthorized($request, 'Oturum açmanız gerekiyor.');
        }

        $user = Auth::user();
        
        if (!$user->role) {
            return $this->unauthorized($request, 'Kullanıcı rolü tanımlanmamış.');
        }

        $permissions = $user->role->permissions ?? collect();

        if (!$permissions->pluck('name')->contains($permission)) {
            return $this->unauthorized($request, 'Bu işlem için yetkiniz yoktur.');
        }

        return $next($request);
    }

    private function unauthorized(Request $request, $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $message], 403);
        }
        
        // Hata mesajını session'a ekle
        session()->flash('error', $message);
        
        // Ana sayfaya yönlendir
        return redirect()->route('index')->with('toastr', [
            'type' => 'error',
            'message' => $message
        ]);
    }
}
