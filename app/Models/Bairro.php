<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importe a classe HasMany

class Bairro extends Model
{
    protected $table = 'bairros';

    protected $fillable = [
        'nome',
        'regiao_id',
    ];

    // Relacionamento: Um bairro pertence a uma região
    public function regiao(): BelongsTo
    {
        return $this->belongsTo(Regiao::class, 'regiao_id');
    }

    // Relacionamento: Um bairro tem muitas escolas
    public function escolas(): HasMany // Corrigido o tipo de retorno
    {
        return $this->hasMany(Escola::class, 'bairro_id');
    }
}