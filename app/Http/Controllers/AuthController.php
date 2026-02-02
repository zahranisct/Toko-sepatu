<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'kasir') {
                return redirect()->route('kasir.dashboard');
            }
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
