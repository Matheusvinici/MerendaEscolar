<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Escola extends Model
{
    protected $table = 'escolas';

    protected $fillable = [
        'nome',
        'inep',
        'bairro_id',
        'pre_escola_alunos', // Total de alunos - Pré-escola
        'fundamental_alunos', // Total de alunos - Fundamental
        'eja_alunos', // Total de alunos - EJA
    ];

    // Relacionamento: Uma escola pertence a um bairro
    public function bairro(): BelongsTo
    {
        return $this->belongsTo(Bairro::class, 'bairro_id');
    }
}