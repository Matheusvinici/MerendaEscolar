<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recebimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'escola_id',
        'user_id',
        'data_recebimento',
        'status',
        'observacoes',
        'atraso_minutos',
        'qualidade_avaliacao',
        'qualidade_observacoes'
    ];

    protected $casts = [
        'data_recebimento' => 'datetime',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function itens()
    {
        return $this->hasMany(RecebimentoItem::class);
    }

    public function anexos()
    {
        return $this->hasMany(RecebimentoAnexo::class);
    }
}