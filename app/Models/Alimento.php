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
        'pre_escola_qtd',
        'pre_escola_alunos',
        'fundamental_qtd',
        'fundamental_alunos',
        'eja_qtd',
        'eja_alunos',
        'total_kg_litro'
    ];

    public function orcamentos()
    {
        return $this->belongsToMany(Orcamento::class, 'orcamento_alimentos')
                    ->withPivot('valor_medio', 'custo_total');
    }
}
