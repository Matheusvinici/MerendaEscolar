<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecebimentoAnexo extends Model
{
    use HasFactory;

    protected $fillable = [
        'recebimento_id',
        'caminho_arquivo',
        'tipo',
        'descricao'
    ];

    public function recebimento()
    {
        return $this->belongsTo(Recebimento::class);
    }
}