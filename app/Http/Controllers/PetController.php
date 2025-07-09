<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::all();
        return view('index', compact('pets'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'raca' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048' // até 2MB
        ]);

        // Se tiver uma imagem, salva no storage
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $data['foto'] = $request->file('foto')->store('pets', 'public');
        }

        // Cria o registro no banco
        Pet::create($data);

        return redirect()->route('index')->with('success', 'Animal cadastrado com sucesso!');
    }

    public function edit(Pet $pet)
    {
        return view('edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'raca' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048'
        ]);

        // Se enviar nova foto, deleta a antiga e salva a nova
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            if ($pet->foto) {
                Storage::disk('public')->delete($pet->foto);
            }

            $data['foto'] = $request->file('foto')->store('pets', 'public');
        }

        // Atualiza o banco
        $pet->update($data);

        return redirect()->route('index')->with('success', 'Animal atualizado!');
    }

    public function destroy(Pet $pet)
    {
        // Remove a foto se houver
        if ($pet->foto) {
            Storage::disk('public')->delete($pet->foto);
        }

        $pet->delete();

        return redirect()->route('index')->with('success', 'Animal removido!');
    }
}
