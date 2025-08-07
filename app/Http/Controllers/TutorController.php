<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
class TutorController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:tutors,cpf',
            'nascimento' => 'required|date',
            'email' => 'required|email|unique:tutors,email',
            'celular' => 'required|string|unique:tutors,celular',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'estado' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'senha' => 'required|string|min:8',
        ]);

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
            'senha' => bcrypt($request->input('senha')),  // Certifique-se de criptografar a senha
        ]);

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
}

}
