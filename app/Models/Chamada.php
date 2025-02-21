<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamada extends Model
{
    protected $table = 'chamadas';

    public function cardapios()
    {
        return $this->hasMany(Cardapio::class, 'chamada_id');
    }

    public function itensPedidos()
    {
        return $this->hasMany(ItemPedido::class, 'chamada_id');
    }
}
