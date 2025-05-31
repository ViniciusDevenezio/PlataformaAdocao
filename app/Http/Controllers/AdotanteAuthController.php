<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdotanteAuthController extends Controller
{
    public function login(Request $request)
    {
        // Valida os campos vindos do form
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentativa de login com os mesmos nomes usados no form
        $credenciais = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::guard('adotante')->attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'E-mail ou senha incorretos.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('adotante')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout realizado com sucesso.');
    }
}
