<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = 'Animais';       // nome exato da tabela
    public $timestamps = false;         // a tabela usa “criado_em”

    protected $fillable = [
        'nome',
        'especie',
        'idade',
        'saude',
        'ong_id',
        'disponivel',
    ];

    protected $casts = [
        'disponivel' => 'boolean',
        'idade'      => 'integer',
    ];

    // Relacionamento (opcional)
    public function ong()
    {
        return $this->belongsTo(Ong::class, 'ong_id');
    }
}
