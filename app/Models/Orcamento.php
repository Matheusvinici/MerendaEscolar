<?php

// app/Models/Orcamento.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'total_estimado',
    ];

    public function orcamentoAlimentos()
    {
       
        return $this->hasMany(OrcamentoAlimento::class);
    }
    public function alimentos()
        {
            return $this->belongsToMany(Alimento::class, 'orcamento_alimentos')
                        ->withPivot('quantidade', 'valor_unitario', 'valor_total')
                        ->withTimestamps();
        }

}
