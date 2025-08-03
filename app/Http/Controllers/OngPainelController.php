<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
    public function cadastrarPet()
    {
        return view('painel.ong.cadastrarPet');
    }

    // 💾 Salvar novo pet
    public function salvarPet(Request $request)
    {
        $request->validate([
            'nome' => 'nullable|string|max:100',
            'descricao' => 'nullable|string',
            'imagem_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // outros campos conforme seu banco
        ]);

        $pet = new Pet($request->except('imagem_url'));
        $pet->ong_id = Auth::guard('ong')->id();
        $pet->slug = Str::slug($request->nome ?? 'sem-nome') . '-' . uniqid();
        $pet->status = 'disponivel';

        // Processar e salvar a imagem com o Storage (como em atualizarPet)
        if ($request->hasFile('imagem_url')) {
            $image = $request->file('imagem_url');
            $nomeImagem = uniqid('pet_') . '.' . $image->getClientOriginalExtension();

            // Salva a imagem em storage/app/public/images
            Storage::disk('public')->putFileAs('images', $image, $nomeImagem);

            // Salva só o nome no banco (acesso via /storage/images/...)
            $pet->imagem_url = $nomeImagem;
        }

        $pet->save();

        return redirect()->route('ong.pets')->with('success', 'Pet cadastrado com sucesso!');
    }

    // EDITAR PET // EDITAR PET
    public function editarPet($id)
    {
        $pet = Pet::where('ong_id', Auth::guard('ong')->id())->findOrFail($id);
        return view('painel.ong.editarPet', compact('pet'));
    }


    // ATUALIZAR PET // ATUALIZAR PET 
    public function atualizarPet(Request $request, $id)
    {
        $pet = Pet::where('ong_id', Auth::guard('ong')->id())->findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'porte' => 'required|string',
            'genero' => 'required|string',
            'status' => 'required|in:disponivel,reservado,adotado',
            'imagem_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // validação da imagem
        ]);

        // Se enviou nova imagem, processa e salva
        if ($request->hasFile('imagem_url')) {
            $image = $request->file('imagem_url');
            $nomeImagem = uniqid('pet_') . '.' . $image->getClientOriginalExtension();

            // Salva a imagem na pasta storage/app/public/images
            Storage::disk('public')->putFileAs('images', $image, $nomeImagem);


            // Atribui ao model (precisa disso antes do update)
            $pet->imagem_url = $nomeImagem;
        }

        // Atualiza os demais campos
        $pet->update([
            'nome' => $request->nome,
            'raca' => $request->raca,
            'mistura' => $request->mistura,
            'misturado_com' => $request->misturado_com,
            'temperamento' => $request->temperamento,
            'porte' => $request->porte,
            'genero' => $request->genero,
            'faixa_etaria' => $request->faixa_etaria,
            'idade' => $request->idade,
            'localizacao' => $request->localizacao,
            'disponivel_ate' => $request->disponivel_ate,
            'status' => $request->status,
            'descricao' => $request->descricao,
            'imagem_url' => $pet->imagem_url, // garante que a nova imagem seja salva
        ]);

        return redirect()->route('ong.pets')->with('success', 'Pet atualizado com sucesso!');
    }

    public function atualizarStatusPet(Request $request, $id)
    {
        $pet = Pet::where('ong_id', Auth::guard('ong')->id())->findOrFail($id);

        $request->validate([
            'status' => 'required|in:disponivel,reservado,adotado',
        ]);

        $pet->status = $request->status;
        $pet->save();

        return back()->with('success', 'Status do pet atualizado com sucesso!');
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
