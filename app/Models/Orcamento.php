<?php

// app/Models/Orcamento.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    protected $fillable = ['descricao', 'data_inicio', 'data_fim', 'dias_letivos', 'total'];

    public function chamadasPublicas()
    {
        return $this->belongsToMany(ChamadaPublica::class, 'chamada_publica_orcamentos')
                    ->withTimestamps(); // Relacionamento de muitos para muitos
    }

    public function alimentos()
    {
        return $this->belongsToMany(Alimento::class, 'orcamento_alimentos', 'orcamento_id', 'alimento_id')
                    ->withPivot('valor_medio', 'custo_total') // Incluindo os campos adicionais da tabela pivô
                    ->withTimestamps(); // Incluindo as timestamps da tabela pivô
    }


}
