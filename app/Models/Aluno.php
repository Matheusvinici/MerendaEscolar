<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'escola_id',
        'creche_parcial',
        'creche_integral',
        'pre_parcial',
        'pre_integral',
        'fundamental_parcial',
        'fundamental_integral',
        'eja',
        'ano_letivo'

    ];

    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }
}