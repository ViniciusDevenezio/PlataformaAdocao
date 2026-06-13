<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;


class PetController extends Controller
{
    public function adotar(Request $request)
    {
        $query = $this->petListQuery();

        if ($request->filled('idade_min')) {
            $query->where('idade', '>=', (int) $request->idade_min);
        }

        $pets = $query->paginate(12)->withQueryString();

        return view('adotar', compact('pets')); // sem 'pets.' antes
    }

    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return view('pets.show', compact('pet'));
    }

    public function reservar($id)
    {
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

public function mostrar(\App\Models\Pet $pet)
{
    // Bloqueia pets reservados ou adotados
    if (in_array($pet->status, ['reservado', 'adotado'])) {
        return redirect()
            ->route('adotar')
            ->with('error', 'Este pet não está disponível no momento.');
    }

    // Exibe normalmente se estiver disponível
    return view('pets.mostrar', ['pet' => $pet]);
}
public function listarCachorros()
{
    $pets = $this->petListQuery('cachorro')->paginate(12)->withQueryString();

    return view('pets.adotarCachorro', compact('pets'));
}
public function listarGatos()
{
    $pets = $this->petListQuery('gato')->paginate(12)->withQueryString();

    return view('pets.adotarGato', compact('pets'));
}

    private function petListQuery(?string $especie = null)
    {
        $query = Pet::query()
            ->select([
                'id',
                'ong_id',
                'nome',
                'slug',
                'especie',
                'porte',
                'genero',
                'idade',
                'status',
                'imagem_url',
                'descricao',
                'created_at',
            ])
            ->with([
                'ong:id,nome,telefone,email,endereco,numero,bairro,cidade,estado',
            ])
            ->latest();

        if ($especie) {
            $query->where('especie', $especie);
        }

        return $query;
    }
}
