<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'nome',
        'raca',
        'foto',               
        'imagem_url',         
        'mistura',
        'misturado_com',
        'temperamento',
        'porte',
        'genero',
        'faixa_etaria',
        'localizacao',
        'disponivel_ate',
        'status',
        'descricao'
    ];

    protected $casts = [
        'mistura' => 'boolean',
        'disponivel_ate' => 'date',
    ];
}
