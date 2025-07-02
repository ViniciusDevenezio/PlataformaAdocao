<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'nome', 'raca', 'mistura', 'misturado_com', 'temperamento',
        'porte', 'genero', 'faixa_etaria', 'localizacao',
        'disponivel_ate', 'status', 'imagem_url', 'descricao',
        'adotante_id' 
    ];

    protected $casts = [
        'mistura' => 'boolean',
        'disponivel_ate' => 'date',
    ];

    public function adotante()
    {
        return $this->belongsTo(Adotante::class);
    }
}