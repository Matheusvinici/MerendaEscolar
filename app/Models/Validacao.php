<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validacao extends Model
{
    protected $table = 'validacoes';

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}
