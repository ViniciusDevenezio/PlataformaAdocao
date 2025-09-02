<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


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
        $temperamentosValidos = [
            'Calmo',
            'Brincalhão',
            'Sociável',
            'Independente',
            'Protetor',
            'Dócil',
            'Energético',
            'Tímido',
            'Carinhoso',
            'Curioso',
            'Vigilante',
            'Tranquilo'
        ];

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'especie' => ['required', 'in:cachorro,gato'],
            'raca' => ['nullable', 'string', 'max:100'],
            'mistura' => ['required', 'in:0,1'],
            'misturado_com' => ['nullable', 'string', 'max:100'],
            'porte' => ['required', 'in:pequeno,medio,grande'],
            'genero' => ['required', 'in:macho,femea'],

            'idade_num' => ['nullable', 'integer', 'min:0'],
            'idade_unidade' => ['nullable', 'in:anos,meses'],
            'idade' => ['nullable', 'string', 'max:50'],

            'status' => ['nullable', 'in:disponivel,reservado,adotado'],

            'temperamento' => ['nullable', 'array', 'max:3'],
            'temperamento.*' => ['string', 'in:' . implode(',', $temperamentosValidos)],

            'localizacao' => ['nullable', 'string', 'max:100'],
            'disponivel_ate' => ['nullable', 'date'],

            'descricao' => ['nullable', 'string', 'max:500'],
            // padronizei os mimes aqui e no update
            'imagem_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            'vacinado' => ['nullable', 'boolean'],
            'vermifugado' => ['nullable', 'boolean'],
        ]);

        // Normalizações
        $dados['nome'] = Str::of($dados['nome'])->trim()->squish()->title();
        if (!empty($dados['raca']))
            $dados['raca'] = Str::of($dados['raca'])->trim()->squish()->title();
        if (!empty($dados['misturado_com']))
            $dados['misturado_com'] = Str::of($dados['misturado_com'])->trim()->squish()->title();

        if (empty($dados['localizacao'])) {
            $dados['localizacao'] = optional(Auth::guard('ong')->user())->cidade;
        }

        $dados['vacinado'] = $request->boolean('vacinado');
        $dados['vermifugado'] = $request->boolean('vermifugado');

        $dados['temperamento'] = !empty($dados['temperamento']) ? implode(',', $dados['temperamento']) : null;

        // Idade -> meses e faixa_etaria
        $idadeMeses = null;
        if (!empty($dados['idade_num']) && !empty($dados['idade_unidade'])) {
            $idadeMeses = $dados['idade_unidade'] === 'anos'
                ? (int) $dados['idade_num'] * 12
                : (int) $dados['idade_num'];
            $dados['idade'] = $dados['idade_num'] . ' ' . $dados['idade_unidade'];
        }
        $dados['faixa_etaria'] = $this->faixaEtariaPorMeses($idadeMeses);

        // slug
        $dados['slug'] = Str::slug(($dados['nome'] ?? 'sem-nome') . '-' . Str::random(6));

        if (empty($dados['status']))
            $dados['status'] = 'disponivel';

        $dados['ong_id'] = Auth::guard('ong')->id();

        // Upload imagem -> salvar nome dentro de $dados
        if ($request->hasFile('imagem_url') && $request->file('imagem_url')->isValid()) {
            $nomeImagem = uniqid('pet_') . '.' . $request->file('imagem_url')->getClientOriginalExtension();

            // força o disco 'public' e salva em storage/app/public/images
            $request->file('imagem_url')->storeAs('images', $nomeImagem, 'public');

            $dados['imagem_url'] = $nomeImagem;
        }


        unset($dados['idade_num'], $dados['idade_unidade']);

        Pet::create($dados);

        return redirect()->route('ong.pets')->with('success', 'Pet cadastrado com sucesso!');
    }
    public function editarPet($id)
    {
        $pet = Pet::where('ong_id', Auth::guard('ong')->id())->findOrFail($id);
        return view('painel.ong.editarPet', compact('pet'));
    }

    // ATUALIZAR PET // ATUALIZAR PET 
    public function atualizarPet(Request $request, $id)
    {
        $pet = Pet::where('ong_id', Auth::guard('ong')->id())->findOrFail($id);

        $temperamentosValidos = [
            'Calmo',
            'Brincalhão',
            'Sociável',
            'Independente',
            'Protetor',
            'Dócil',
            'Energético',
            'Tímido',
            'Carinhoso',
            'Curioso',
            'Vigilante',
            'Tranquilo'
        ];

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'especie' => ['required', 'in:cachorro,gato'],
            'raca' => ['nullable', 'string', 'max:100'],
            'mistura' => ['required', 'in:0,1'],
            'misturado_com' => ['nullable', 'string', 'max:100'],
            'porte' => ['required', 'in:pequeno,medio,grande'],
            'genero' => ['required', 'in:macho,femea'],

            'idade_num' => ['nullable', 'integer', 'min:0'],
            'idade_unidade' => ['nullable', 'in:anos,meses'],
            'idade' => ['nullable', 'string', 'max:50'],

            'status' => ['required', 'in:disponivel,reservado,adotado'],
            'disponivel_ate' => ['nullable', 'date'],

            'temperamento' => ['nullable', 'array', 'max:3'],
            'temperamento.*' => ['string', 'in:' . implode(',', $temperamentosValidos)],

            'localizacao' => ['nullable', 'string', 'max:100'],
            'descricao' => ['nullable', 'string', 'max:500'],

            'imagem_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],

            'vacinado' => ['nullable', 'boolean'],
            'vermifugado' => ['nullable', 'boolean'],
        ]);

        // Normalizações
        $dados['nome'] = Str::of($dados['nome'])->trim()->squish()->title();
        if (!empty($dados['raca']))
            $dados['raca'] = Str::of($dados['raca'])->trim()->squish()->title();
        if (!empty($dados['misturado_com']))
            $dados['misturado_com'] = Str::of($dados['misturado_com'])->trim()->squish()->title();

        // Localização default (se vazio mantém a atual ou usa cidade ONG)
        if (empty($dados['localizacao'])) {
            $dados['localizacao'] = $pet->localizacao ?? optional(Auth::guard('ong')->user())->cidade;
        }

        // Saúde
        $dados['vacinado'] = $request->boolean('vacinado');
        $dados['vermifugado'] = $request->boolean('vermifugado');

        // Chips -> string
        $dados['temperamento'] = !empty($dados['temperamento']) ? implode(',', $dados['temperamento']) : null;

        // Idade -> meses -> faixa_etaria
        $idadeMeses = null;
        if (!empty($dados['idade_num']) && !empty($dados['idade_unidade'])) {
            $idadeMeses = $dados['idade_unidade'] === 'anos'
                ? (int) $dados['idade_num'] * 12
                : (int) $dados['idade_num'];
            $dados['idade'] = $dados['idade_num'] . ' ' . $dados['idade_unidade'];
        } else {
            // se não veio nada no form de idade, mantém a já salva para não zerar faixa_etaria sem querer
            if ($pet->idade) {
                // tenta inferir meses da string já salva
                $idadeMeses = $this->parseIdadeToMeses($pet->idade);
            }
        }
        $dados['faixa_etaria'] = $this->faixaEtariaPorMeses($idadeMeses);

        // Imagem
        if ($request->hasFile('imagem_url') && $request->file('imagem_url')->isValid()) {
            // remove a imagem antiga, se existir
            if ($pet->imagem_url && Storage::disk('public')->exists('images/' . $pet->imagem_url)) {
                Storage::disk('public')->delete('images/' . $pet->imagem_url);
            }

            $nomeImagem = uniqid('pet_') . '.' . $request->file('imagem_url')->getClientOriginalExtension();

            // salva em storage/app/public/images
            $request->file('imagem_url')->storeAs('images', $nomeImagem, 'public');

            $dados['imagem_url'] = $nomeImagem;
        }


        unset($dados['idade_num'], $dados['idade_unidade']);

        $pet->update($dados);

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

    private function faixaEtariaPorMeses(?int $m): ?string
    {
        if ($m === null)
            return null;
        $anos = $m / 12;

        if ($anos < 1)
            return 'Filhote';
        elseif ($anos < 4)
            return 'Jovem';
        elseif ($anos <= 10)
            return 'Adulto';
        else
            return 'Idoso';
    }

    /** Converte "2 anos" / "8 meses" / "1 ano" para meses (int) */
    private function parseIdadeToMeses(?string $idade): ?int
    {
        if (!$idade)
            return null;

        $s = mb_strtolower(trim($idade), 'UTF-8');
        $s = preg_replace('/\s+/', ' ', $s);

        if (preg_match('/(\d+)\s*(ano|anos|mês|meses)/u', $s, $m)) {
            $num = (int) $m[1];
            $uni = $m[2];

            if (in_array($uni, ['ano', 'anos']))
                return $num * 12;
            if (in_array($uni, ['mês', 'meses']))
                return $num;
        }

        // fallback: só número -> assume meses
        if (preg_match('/^\d+$/', $s))
            return (int) $s;

        return null;
    }
}
