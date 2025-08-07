<?php

namespace App\Http\Controllers;

use App\Models\Adotante;
use Illuminate\Http\Request;
class AdotanteController extends Controller
{
    public function index()
    {
        $adotantes = Adotante::all();
        return view('adotantes.index', compact('adotantes'));
    }

    public function create()
    {
        return view('adotantes.create');
    }

    public function store(Request $request)
{
    // Etapa 1: Validação inicial dos outros campos (sem nascimento ainda convertido)
    $request->validate([
        'nome_completo' => 'required',
        'cpf' => 'required|unique:adotantes,cpf',
        'nascimento' => 'required',
        'email' => 'required|email|unique:adotantes,email',
        'celular' => 'required',
        'senha' => 'required|min:6',
        'endereco' => 'required',
        'cep' => ['required', 'regex:/^\d{5}-?\d{3}$/'],
        'numero' => 'required',
        'bairro' => 'required',
        'estado' => 'required',
        'cidade' => 'required',
    ]);

    // Etapa 2: Converter nascimento de d/m/Y para Y-m-d
    $data = \DateTime::createFromFormat('d/m/Y', $request->nascimento);

    if (!$data) {
        return back()->withErrors(['nascimento' => 'Data de nascimento inválida.'])->withInput();
    }

    // Etapa 3: Validar idade entre 18 e 80 anos
    $idade = $data->diff(new \DateTime('now'))->y;
    if ($idade < 18 || $idade > 80) {
        return back()->withErrors(['nascimento' => 'A idade deve estar entre 18 e 80 anos.'])->withInput();
    }

    // Etapa 4: Preparar dados para salvar
    $dados = $request->all();
    $dados['nascimento'] = $data->format('Y-m-d');
    $dados['senha'] = bcrypt($dados['senha']);

    // Salvar adotante
    Adotante::create($dados);

    return back()->with('success', 'Adotante cadastrado com sucesso!');
}
}
