<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\Solicitacao;


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

        try {
            // Tenta como Adotante
            if (Auth::guard('adotante')->attempt($credenciais)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }

            // Tenta como ONG
            if (Auth::guard('ong')->attempt($credenciais)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
        } catch (QueryException $exception) {
            report($exception);

            return back()->withErrors([
                'email' => 'Nao foi possivel conectar ao banco de dados. Verifique se o MySQL esta ligado e tente novamente.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'E-mail ou senha incorretos.',
        ])->onlyInput('email');
    }

    public function painelAdotante()
    {
        $adotante = Auth::guard('adotante')->user();
        $solicitacoes = Solicitacao::with('pet')
            ->where('adotante_id', $adotante->id)
            ->orderByDesc('created_at')
            ->get();

        return view('painelAdotante', compact('solicitacoes'));
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
