<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{
    use HasFactory;

    protected $fillable = ['chamada_publica_id', 'alimento_id', 'valor_total', 'status'];

    // Relacionamento com ChamadaPublica
    public function chamadaPublica()
    {
        return $this->belongsTo(ChamadaPublica::class);
    }

    public function alimentos()
    {
        return $this->belongsToMany(Alimento::class, 'proposta_alimentos')
                    ->withPivot('quantidade_ofertada','quantidade_aprovada', 'valor_total')
                    ->withTimestamps();
    }
    
    public function regiao()
    {
        return $this->belongsTo(Regiao::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function getTotalAprovadoPorAlimento($alimentoId)
    {
        return $this->avaliacoes()
                    ->where('status', 'aprovada')
                    ->whereHas('alimentos', function ($query) use ($alimentoId) {
                        $query->where('alimento_id', $alimentoId);
                    })
                    ->sum('quantidade_aprovada');
    }

    
}
