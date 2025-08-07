<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Adotante;
use App\Models\Ong;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function loginUnificado(Request $request)
    {
        // Remova depois de testar
        // dd('Entrou no método loginUnificado');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta ONG
        $ong = Ong::where('email', $request->email)->first();
        if ($ong && Hash::check($request->password, $ong->senha)) {
            Auth::guard('ong')->login($ong);
            return redirect()->intended('/');
        }

        // Tenta Adotante
        $adotante = Adotante::where('email', $request->email)->first();
        if ($adotante && Hash::check($request->password, $adotante->senha)) {
            Auth::guard('adotante')->login($adotante);
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
    }

    public function logout(Request $request)
    {
        if (Auth::guard('ong')->check()) {
            Auth::guard('ong')->logout();
        } elseif (Auth::guard('adotante')->check()) {
            Auth::guard('adotante')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout realizado com sucesso!');
    }
}