<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;


class PetController extends Controller
{
    public function adotar()
    {
        $pets = Pet::all();
        return view('adotar', compact('pets')); // sem 'pets.' antes
    }

    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return view('pets.show', compact('pet'));
    }

    public function reservar($id){
        $pet = Pet::findOrFail($id);

        // Verifica se está disponível
        if ($pet->status !== 'disponivel') {
            return redirect()->back()->with('error', 'Este pet não está disponível para reserva.');
        }

        // Verifica se o usuário está autenticado como adotante
        if (!Auth::guard('adotante')->check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado como adotante para reservar um pet.');
        }

        $adotante = Auth::guard('adotante')->user();

        // Atualiza pet com o adotante e status
        $pet->adotante_id = $adotante->id;
        $pet->status = 'aguardando_aprovacao';
        $pet->save();

        return redirect()->back()->with('success', 'Pet reservado com sucesso. Aguardando aprovação da ONG.');
    }

}
