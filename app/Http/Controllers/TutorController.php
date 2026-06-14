<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TutorController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate(
            [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|unique:tutor,cpf',
                'nascimento' => 'required|date',
                'email' => 'required|email|unique:tutor,email',
                'celular' => 'required|string|unique:tutor,celular',
                'endereco' => 'required|string|max:255',
                'bairro' => 'required|string|max:255',
                'estado' => 'nullable|string|max:255',
                'cidade' => 'nullable|string|max:255',
                'numero' => 'nullable|string|max:255',
                'complemento' => 'nullable|string|max:255',
                'senha' => 'required|string|min:8|max:72',
            ],
            [
                'required' => 'O campo :attribute é obrigatório.',
                'string' => 'O campo :attribute deve ser um texto válido.',
                'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
                'unique' => 'O valor informado para :attribute já está em uso.',
                'email' => 'Informe um e-mail válido.',
                'date' => 'Informe uma data válida.',
                'min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
            ]
        );

        // Criação de um novo tutor
        Tutor::create([
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'nascimento' => $request->input('nascimento'),
            'email' => $request->input('email'),
            'celular' => $request->input('celular'),
            'endereco' => $request->input('endereco'),
            'numero' => $request->input('numero'),
            'complemento' => $request->input('complemento'),
            'bairro' => $request->input('bairro'),
            'estado' => $request->input('estado'),
            'cidade' => $request->input('cidade'),
            'senha' => Hash::make($request->input('senha')),
        ]);

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
    }
}
