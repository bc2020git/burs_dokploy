<?php

// app/Http/Controllers/StudentAuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class RenewStudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.student.active.student-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('student_select_type');
        }

        return back()->withErrors([
            'email' => 'Kayitli eposta  bulunmuyor',
        ]);
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect('/student/login');
    }
}
