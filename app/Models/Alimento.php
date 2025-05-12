<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'unidade_medida',
        'creche_parcial_per_capita',
        'pre_integral_per_capita',
        'fundamental_parcial_per_capita',
        'fundamental_integral_per_capita',
        'incidencia_creche_parcial',
        'incidencia_pre_integral',
        'incidencia_fundamental_parcial',
        'incidencia_fundamental_integral',
        'disponivel_quinzena',
        'ativo'
    ];

    protected $casts = [
        'disponivel_quinzena' => 'boolean',
        'ativo' => 'boolean',
        'creche_parcial_per_capita' => 'decimal:3',
        'pre_integral_per_capita' => 'decimal:3',
        'fundamental_parcial_per_capita' => 'decimal:3',
        'fundamental_integral_per_capita' => 'decimal:3',
        'incidencia_creche_parcial' => 'decimal:2',
        'incidencia_pre_integral' => 'decimal:2',
        'incidencia_fundamental_parcial' => 'decimal:2',
        'incidencia_fundamental_integral' => 'decimal:2'
    ];

    public function cardapios()
    {
        return $this->belongsToMany(Cardapio::class)
                    ->withPivot('dia_semana', 'refeicao');
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class);
    }
    
}