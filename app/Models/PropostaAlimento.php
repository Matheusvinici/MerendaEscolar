<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropostaAlimento extends Model
{
    use HasFactory;

    protected $fillable = ['proposta_id', 'alimento_id', 'quantidade_ofertada', 'valor_total'];

    // Relacionamento com Proposta
    public function proposta()
    {
        return $this->belongsTo(Proposta::class);
    }

    // Relacionamento com Alimento
    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }
}
