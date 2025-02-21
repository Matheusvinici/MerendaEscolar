<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualidade extends Model
{
    protected $table = 'qualidades';

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'entrega_id');
    }
}
