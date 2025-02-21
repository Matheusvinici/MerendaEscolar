<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}
