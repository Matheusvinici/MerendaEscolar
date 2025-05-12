<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardapio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'escola_id',
        'segmento_id',
        'data_inicio',
        'data_fim',
        'observacoes',
        'ativo',
        'padrao'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'padrao' => 'boolean',
        'data_inicio' => 'date',
        'data_fim' => 'date'
    ];

    public function alimentos()
    {
        return $this->belongsToMany(Alimento::class)
                    ->withPivot('dia_semana', 'refeicao')
                    ->withTimestamps();
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }

    public function segmento()
    {
        return $this->belongsTo(Segmento::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePadrao($query)
    {
        return $query->where('padrao', true);
    }
}