<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 
        'inep'
    ];

    // Relações
    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class);
    }
}
