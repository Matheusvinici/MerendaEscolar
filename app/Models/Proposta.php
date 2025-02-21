<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{
    protected $table = 'propostas';

    public function itemPedido()
    {
        return $this->belongsTo(ItemPedido::class, 'item_id');
    }

    public function produtor()
    {
        return $this->belongsTo(Produtor::class, 'produtor_id');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'proposta_id');
    }
}
