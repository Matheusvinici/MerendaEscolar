<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    protected $table = 'alimentos';

    public function cardapios()
    {
        return $this->hasMany(Cardapio::class, 'alimento_id');
    }
}
