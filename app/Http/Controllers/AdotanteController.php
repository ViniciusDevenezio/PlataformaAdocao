<?php

namespace App\Http\Controllers;

use App\Models\Adotante;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdotanteController extends Controller
{
    public function index()
    {
        $adotantes = Adotante::all();

        return view('adotantes.index', compact('adotantes'));
    }

    public function create()
    {
        return view('adotantes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nome_completo' => ['required', 'string', 'max:255'],
                'cpf' => ['required', 'string', 'max:14', 'unique:adotantes,cpf'],
                'nascimento' => ['required', 'string'],
                'email' => ['required', 'email', 'max:255', 'unique:adotantes,email'],
                'celular' => ['required', 'string', 'max:20'],
                'senha' => ['required', 'string', 'min:8', 'max:72'],
                'endereco' => ['required', 'string', 'max:255'],
                'cep' => ['required', 'regex:/^\d{5}-?\d{3}$/'],
                'numero' => ['required', 'string', 'max:50'],
                'bairro' => ['required', 'string', 'max:255'],
                'estado' => ['required', 'string', 'max:2'],
                'cidade' => ['required', 'string', 'max:255'],
                'lgpd_aceite' => ['accepted'],
            ],
            [
                'required' => 'O campo :attribute e obrigatorio.',
                'unique' => 'O valor informado para :attribute ja esta em uso.',
                'email' => 'Informe um e-mail valido.',
                'min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
                'accepted' => 'E necessario aceitar :attribute.',
                'regex' => 'O campo :attribute nao esta em um formato valido.',
            ]
        );

        $data = DateTimeImmutable::createFromFormat('d/m/Y', $validated['nascimento']);
        $dateErrors = DateTimeImmutable::getLastErrors();

        if (!$data || ($dateErrors && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))) {
            return back()->withErrors(['nascimento' => 'Data de nascimento invalida.'])->withInput();
        }

        $idade = $data->diff(new DateTimeImmutable('now'))->y;
        if ($idade < 18 || $idade > 80) {
            return back()->withErrors(['nascimento' => 'A idade deve estar entre 18 e 80 anos.'])->withInput();
        }

        $dados = $validated;
        $dados['nascimento'] = $data->format('Y-m-d');
        $dados['senha'] = Hash::make($validated['senha']);
        unset($dados['lgpd_aceite']);

        Adotante::create($dados);

        return redirect()
            ->route('login')
            ->with('success', 'Cadastro realizado com sucesso!');
    }
}
