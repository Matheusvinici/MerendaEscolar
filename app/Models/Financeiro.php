<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    protected $table = 'financeiros';

    public function cardapio()
    {
        return $this->belongsTo(Cardapio::class, 'cardapio_id');
    }
}
