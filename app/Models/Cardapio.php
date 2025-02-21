<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cardapio extends Model
{
    protected $table = 'cardapios';

    public function chamada()
    {
        return $this->belongsTo(Chamada::class, 'chamada_id');
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'alimento_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cardapio_id');
    }
}
