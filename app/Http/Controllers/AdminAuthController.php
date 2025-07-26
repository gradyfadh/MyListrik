<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Login sebagai admin menggunakan guard 'web'
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            Session::put('logged_id', Auth::guard('web')->id());
            Session::put('logged_in', true);
            Session::put('level', 1); // admin
            return redirect()->route('admin.dashboard.index');
        }

        // Jika gagal login
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email / Password salah.');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Session::flush();
        return redirect()->route('login');
    }
}
