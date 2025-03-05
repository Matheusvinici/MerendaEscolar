<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'escola_id',
        'proposta_id',
        'alimento_id',
        'quantidade_pedida',
        'quantidade_entregue',
        'data_pedido',
        'data_entrega',
    ];

    /**
     * Relacionamento com a tabela `escolas`.
     */
    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }

    /**
     * Relacionamento com a tabela `propostas`.
     */
    public function proposta()
    {
        return $this->belongsTo(Proposta::class);
    }

    /**
     * Relacionamento com a tabela `alimentos`.
     */
    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }
}