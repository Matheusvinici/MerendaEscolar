<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    protected $table = 'alimentos';

    protected $fillable = ['nome', 'unidade_medida', 'valor_medio', 'especificacao', 'periodicidade'];


    public function cardapios()
    {
        return $this->hasMany(Cardapio::class, 'alimento_id');
    }
}
