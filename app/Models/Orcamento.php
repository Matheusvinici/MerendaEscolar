<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'data_inicio', 'data_fim', 'dias_letivos', 'total'];

    public function alimentos()
    {
        return $this->belongsToMany(Alimento::class, 'orcamento_alimentos')
                    ->withPivot('valor_medio', 'custo_total');
    }
  
}
