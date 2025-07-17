<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OngPainelController extends Controller
{
    // 🏠 Página inicial (já renderizada direto na rota como 'painelOng')
    // public function dashboard() {
    //     return view('painelOng');
    // }

    // 📋 Listar pets da ONG logada
    public function listarPets()
    {
        $pets = Pet::where('ong_id', Auth::guard('ong')->id())->get();
        return view('painel.ong.pets', compact('pets'));
    }

    // ➕ Formulário para cadastrar novo pet
    public function formPet()
    {
        return view('painel.ong.formPet');
    }

    // 💾 Salvar novo pet
    public function salvarPet(Request $request)
    {
        $request->validate([
            'nome' => 'nullable|string|max:100',
            'descricao' => 'nullable|string',
            'imagem_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            // outros campos conforme seu banco
        ]);

        $nomeArquivo = time() . '.' . $request->imagem_url->extension();
        $request->imagem_url->move(public_path('images'), $nomeArquivo);

        $pet = new Pet($request->all());
        $pet->ong_id = Auth::guard('ong')->id();
        $pet->slug = Str::slug($request->nome ?? 'sem-nome') . '-' . uniqid();
        $pet->imagem_url = $nomeArquivo;
        $pet->status = 'disponivel';
        $pet->save();

        return redirect()->route('ong.pets')->with('success', 'Pet cadastrado com sucesso!');
    }

    // ✏️ Editar pet
    public function editarPet($id)
    {
        $pet = Pet::where('ong_id', Auth::guard('ong')->id())->findOrFail($id);
        return view('painel.ong.editarPet', compact('pet'));
    }

    // 🔄 Atualizar pet
    public function atualizarPet(Request $request, $id)
    {
        $pet = Pet::where('ong_id', Auth::guard('ong')->id())->findOrFail($id);

        $pet->fill($request->except('imagem_url'));

        if ($request->hasFile('imagem_url')) {
            $nomeArquivo = time() . '.' . $request->imagem_url->extension();
            $request->imagem_url->move(public_path('images'), $nomeArquivo);
            $pet->imagem_url = $nomeArquivo;
        }

        $pet->save();

        return redirect()->route('ong.pets')->with('success', 'Pet atualizado com sucesso!');
    }

    // ❌ Excluir pet
    public function excluirPet($id)
    {
        $pet = Pet::where('ong_id', Auth::guard('ong')->id())->findOrFail($id);
        $pet->delete();

        return redirect()->route('ong.pets')->with('success', 'Pet removido com sucesso!');
    }

    // 📨 Ver interesses (exemplo simples, você pode ajustar)
    public function interesses()
    {
        // aqui você pode buscar pets com algum relacionamento "interesses"
        $pets = Pet::where('ong_id', Auth::guard('ong')->id())->get();
        return view('painel.ong.interesses', compact('pets'));
    }
}
