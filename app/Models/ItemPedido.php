<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table = 'itens_pedido'; // Especifica o nome correto da tabela
    
    protected $fillable = [
        'pedido_id',
        'alimento_id',
        'quantidade',
        'unidade_medida',
        'incidencia_creche_parcial',
        'incidencia_creche_integral',
        'incidencia_pre_parcial',
        'incidencia_pre_integral',
        'incidencia_fundamental_parcial',
        'incidencia_fundamental_integral',
        'incidencia_eja',
        'valor_unitario',
        'valor_total'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }
}