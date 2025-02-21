<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entregas';

    public function propostaVenda()
    {
        return $this->belongsTo(PropostaVenda::class, 'proposta_venda_id');
    }

    public function qualidade()
    {
        return $this->hasOne(Qualidade::class, 'entrega_id');
    }
}
