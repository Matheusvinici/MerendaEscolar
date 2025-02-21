<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    public function cardapio()
    {
        return $this->belongsTo(Cardapio::class, 'cardapio_id');
    }
}
