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
        return $this->belongsToMany(Orcamento::class, 'orcamento_alimentos', 'alimento_id', 'orcamento_id')
                    ->withPivot('valor_medio', 'custo_total') // Incluindo os campos adicionais da tabela pivô
                    ->withTimestamps(); // Incluindo as timestamps da tabela pivô
    }

    public function chamadasPublicas()
    {
        return $this->belongsToMany(ChamadaPublica::class, 'chamada_publica_alimento');
    }

    public function propostas()
    {
        return $this->belongsToMany(Proposta::class, 'proposta_alimentos')
                    ->withPivot('quantidade_ofertada', 'valor_total')
                    ->withTimestamps();
    }

    public function orcamentoAlimento()
    {
        return $this->hasOne(OrcamentoAlimento::class, 'alimento_id');
    }
    

   
}
