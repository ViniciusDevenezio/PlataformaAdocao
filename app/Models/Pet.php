<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pet extends Model
{
    protected $fillable = [
        'ong_id',
        'nome','especie','raca','mistura','misturado_com','temperamento',
        'porte','genero','faixa_etaria','idade','localizacao',
        'disponivel_ate','status','imagem_url','descricao',
        'vacinado','vermifugado',
        'adotante_id','slug',
    ];

    protected $casts = [
        'mistura'        => 'boolean',
        'vacinado'       => 'boolean',
        'vermifugado'    => 'boolean',
        'disponivel_ate' => 'date',
    ];

    // Acesso como array (explode da string salva "Calmo,Brincalhão")
    public function getTemperamentoArrayAttribute(): array
    {
        return $this->temperamento ? explode(',', $this->temperamento) : [];
    }

    // Gera slug automático se não vier
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pet) {
            if (empty($pet->slug)) {
                $pet->slug = Str::slug($pet->nome.'-'.Str::random(6));
            }
        });
    }

    public function getRouteKeyName()
{
    return 'slug';
}


    public function ong()
    {
        return $this->belongsTo(Ong::class);
    }

    public function adotante()
    {
        return $this->belongsTo(Adotante::class);
    }
}
