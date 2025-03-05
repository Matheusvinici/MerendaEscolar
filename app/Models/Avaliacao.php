<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;
    
    protected $table = 'avaliacoes';

    protected $fillable = [
        'proposta_id',
        'user_id',
        'status',
        'comentario',
        'quantidade_aprovada',
    ];

    // Relacionamento com Proposta
    public function proposta()
    {
        return $this->belongsTo(Proposta::class);
    }

    // Relacionamento com Usuário (quem avaliou)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}