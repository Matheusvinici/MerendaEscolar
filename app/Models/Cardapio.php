<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardapio extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'quantidade_porcao_gr',
        'quantidade_kg',
        'dias_servido',
        'alimento_id',
        'escola_id',
    ];

    // Relacionamento com a escola
    public function escola()
    {
        return $this->belongsTo(Escola::class, 'escola_id');
    }

    // Relacionamento com o alimento
    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'alimento_id');
    }

  
}