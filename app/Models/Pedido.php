<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'escola_id',
        'cardapio_id',
        'user_id',
        'data_inicio',
        'data_fim',
        'status',
        'lote_id',
        'observacoes'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date'
    ];

    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }

    public function cardapio()
    {
        return $this->belongsTo(Cardapio::class)->withDefault([
            'nome' => 'Sem cardápio associado'
        ]);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function itens()
    {
        return $this->hasMany(ItemPedido::class);
    }

    public function calcularTotal()
    {
        return $this->itens->sum('valor_total');
    }
}