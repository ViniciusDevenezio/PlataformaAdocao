<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Ong;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /** Listagem */
    public function index()
    {
        $animais = Animal::with('ong')->get();
        return view('index', compact('animais')); // ← sem subpasta
    }

    /** Formulário de criação */
        public function create()
            {
                $ongs = Ong::pluck('nome', 'id'); // [$id => $nome]
                return view('create', compact('ongs'));
            }


    /** Salvar novo animal */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'       => 'required|string|max:255',
            'especie'    => 'required|in:Cachorro,Gato,Outro',
            'idade'      => 'nullable|integer|min:0',
            'saude'      => 'nullable|string',
            'ong_id'     => 'required|exists:ongs,id', // ← nome da tabela
            'disponivel' => 'boolean',
        ]);

        $data['disponivel'] = $request->boolean('disponivel');

        Animal::create($data);

        return redirect()->route('pets.index')
                         ->with('success', 'Animal cadastrado com sucesso!');
    }

    /** Detalhes */
    public function show(string $id)
    {
        $animal = Animal::with('ong')->findOrFail($id);
        return view('show', compact('animal')); // ← caso crie um show.blade.php
    }

    /** Formulário de edição */
    public function edit(string $id)
    {
        $animal = Animal::findOrFail($id);
        $ongs = Ong::pluck('nome', 'id');
        return view('edit', compact('animal', 'ongs')); // ← sem subpasta
    }

    /** Atualizar */
    public function update(Request $request, string $id)
    {
        $animal = Animal::findOrFail($id);

        $data = $request->validate([
            'nome'       => 'required|string|max:255',
            'especie'    => 'required|in:Cachorro,Gato,Outro',
            'idade'      => 'nullable|integer|min:0',
            'saude'      => 'nullable|string',
            'ong_id'     => 'required|exists:ongs,id',
            'disponivel' => 'boolean',
        ]);

        $data['disponivel'] = $request->boolean('disponivel');
        $animal->update($data);

        return redirect()->route('pets.index')
                         ->with('success', 'Animal atualizado com sucesso!');
    }

    /** Remover */
    public function destroy(string $id)
    {
        $animal = Animal::findOrFail($id);
        $animal->delete();

        return redirect()->route('pets.index')
                         ->with('success', 'Animal removido com sucesso!');
    }
}
