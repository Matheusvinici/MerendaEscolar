<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'itens';

    public function chamadaPublica()
    {
        return $this->belongsTo(Chamada::class, 'chamada_id');
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class, 'escola_id');
    }

    public function propostasVenda()
    {
        return $this->hasMany(PropostaVenda::class, 'item_id');
    }
}
