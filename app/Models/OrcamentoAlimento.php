<?php

// app/Models/OrcamentoAlimento.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoAlimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'orcamento_id',
        'alimento_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class);
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }
}
