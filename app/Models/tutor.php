<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model // Ajuste para iniciar com letra maiúscula
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'tutor'; // Define que a tabela é "tutor"

    protected $fillable = [
        'nome', 'cpf', 'nascimento', 'email', 'celular', 
        'email_verified_at', 'endereco', 'numero', 
        'complemento', 'bairro', 'estado', 'cidade'
    ];

    protected $guarded = ['id', 'senha']; // Impede edição direta nesses campos
}
