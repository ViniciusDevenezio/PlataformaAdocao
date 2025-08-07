<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <- modulo de autenticação do laravel
use Illuminate\Notifications\Notifiable;

class Adotante extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nome_completo',
        'cpf',
        'nascimento',
        'email',
        'celular',
        'senha',
        'cep',
        'endereco',
        'numero',
        'bairro',
        'estado',
        'cidade',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * Define qual campo será usado como senha para autenticação
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }
}
