<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function register() {
        return view('auth.register');
    }

    // ================= REGISTER USER =================
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga', // ⬅️ otomatis jadi warga
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
    }

    // ================= LOGIN =================
    public function authenticate(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email','password'))) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // ================= LOGOUT =================
    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
