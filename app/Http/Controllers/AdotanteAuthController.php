<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdotanteAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Tenta como Adotante
        if (Auth::guard('adotante')->attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect('/'); 
        }

        // Tenta como ONG
        if (Auth::guard('ong')->attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect('/'); 
        }

        return back()->withErrors([
            'email' => 'E-mail ou senha incorretos.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
{
    if (Auth::guard('ong')->check()) {
        Auth::guard('ong')->logout();
    }

    if (Auth::guard('adotante')->check()) {
        Auth::guard('adotante')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Logout realizado com sucesso.');
}
}
