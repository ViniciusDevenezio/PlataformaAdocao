<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'tutor';

    protected $fillable = [
        'nome',
        'cpf',
        'nascimento',
        'email',
        'celular',
        'email_verified_at',
        'endereco',
        'numero',
        'senha',
        'complemento',
        'bairro',
        'estado',
        'cidade',
    ];

    protected $guarded = ['id'];
}
