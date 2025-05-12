<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecebimentoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'recebimento_id',
        'item_pedido_id',
        'quantidade_prevista',
        'quantidade_recebida',
        'diferenca',
        'observacoes'
    ];

    public function recebimento()
    {
        return $this->belongsTo(Recebimento::class);
    }

    public function itemPedido()
    {
        return $this->belongsTo(ItemPedido::class);
    }
}