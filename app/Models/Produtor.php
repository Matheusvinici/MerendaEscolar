<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtor extends Model
{
    protected $table = 'produtores';

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'produtor_id');
    }

    public function propostasVenda()
    {
        return $this->hasMany(PropostaVenda::class, 'produtor_id');
    }
}
