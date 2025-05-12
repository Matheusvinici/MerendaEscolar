<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segmento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function cardapios()
    {
        return $this->hasMany(Cardapio::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}