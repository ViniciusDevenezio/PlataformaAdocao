<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OngController extends Controller
{
    public function create()
    {
        return view('cadastroOng');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:ongs,email'],
            'senha' => ['required', 'string', 'min:8', 'max:72'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'cnpj' => ['required', 'string', 'max:18', 'unique:ongs,cnpj'],
            'cep' => ['required', 'regex:/^\d{5}-?\d{3}$/'],
            'endereco' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:50'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:2'],
        ]);

        $validated['senha'] = Hash::make($validated['senha']);

        Ong::create($validated);

        return back()->with('success', 'ONG cadastrada com sucesso!');
    }
}
