<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    protected $table = 'solicitacoes';

    protected $fillable = [
        'pet_id',
        'adotante_id',
        'ong_id',
        'celular_cache',
        'mensagem',
        'status',
    ];

    public function pet()      { return $this->belongsTo(\App\Models\Pet::class); }
    public function adotante() { return $this->belongsTo(\App\Models\Adotante::class); }
    public function ong()      { return $this->belongsTo(\App\Models\Ong::class); }
}
