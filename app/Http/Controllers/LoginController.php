<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Adotante;
    use Illuminate\Support\Facades\Hash;

    class LoginController extends Controller
    {
        public function showLoginForm()
        {
            return view('login'); // sua view de login
        }

        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'senha' => 'required',
            ]);

            $adotante = Adotante::where('email', $request->email)->first();

            if ($adotante && Hash::check($request->senha, $adotante->senha)) {
                Auth::login($adotante); // ← AUTENTICA usando Laravel
                return redirect()->route('dashboard')->with('success', 'Login realizado com sucesso!');
            }

            return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput();
        }

        public function logout()
        {
            Auth::logout(); // ← usa o logout do Laravel
            return redirect()->route('login')->with('success', 'Logout realizado com sucesso!');
        }
    }
