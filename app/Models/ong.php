<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ong extends Model
{
    
    protected $table = 'ongs';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'senha',
        'endereco',
    ];
}
