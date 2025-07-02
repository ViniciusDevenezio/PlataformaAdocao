<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Ong extends Authenticatable
{
    use Notifiable;

    protected $table = 'ongs';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'telefone',
        'cnpj',
        'cep',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
    ];

    protected $hidden = ['senha', 'remember_token'];

    /**
     * Laravel precisa saber onde está a senha do usuário
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    // Relacionamento com pets
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
