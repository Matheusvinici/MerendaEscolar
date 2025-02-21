<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    protected $table = 'escolas';

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'escola_id');
    }

    public function itensPedidos()
    {
        return $this->hasMany(ItemPedido::class, 'escola_id');
    }
}
