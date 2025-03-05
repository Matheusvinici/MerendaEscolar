<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regiao extends Model
{
    use HasFactory;

    protected $table = 'regioes';

    protected $fillable = [
        'nome',
    ];

    // Relacionamento: Uma região tem muitos bairros
    public function bairros(): HasMany
    {
        return $this->hasMany(Bairro::class, 'regiao_id');
    }
}