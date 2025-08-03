<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pet extends Model
{
    protected $fillable = [
        'ong_id',
        'nome', 'raca', 'mistura', 'misturado_com', 'temperamento',
        'porte', 'genero', 'faixa_etaria','idade', 'localizacao',
        'disponivel_ate', 'status', 'imagem_url', 'descricao',
        'adotante_id', 'slug' 
    ];

    protected $casts = [
        'mistura' => 'boolean',
        'disponivel_ate' => 'date',
    ];

    // ⬇️ Aqui entra o método boot para gerar o slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pet) {
            if (empty($pet->slug)) {
                $base = $pet->nome ?? 'sem-nome';
                $pet->slug = Str::slug($base) . '-' . uniqid();
            }
        });
    }

    public function adotante()
    {
        return $this->belongsTo(Adotante::class);
    }

    public function ong()
    {
        return $this->belongsTo(Ong::class);
    }
}
