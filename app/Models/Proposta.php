<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{
    use HasFactory;

    protected $fillable = ['chamada_publica_id', 'alimento_id', 'valor_total'];

    // Relacionamento com ChamadaPublica
    public function chamadaPublica()
    {
        return $this->belongsTo(ChamadaPublica::class);
    }

    public function alimentos()
    {
        return $this->belongsToMany(Alimento::class, 'proposta_alimentos')
                    ->withPivot('quantidade_ofertada', 'valor_total')
                    ->withTimestamps();
    }


    
}
