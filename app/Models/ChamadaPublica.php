<?php

// app/Models/ChamadaPublica.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamadaPublica extends Model
{
    protected $table = 'chamadas_publicas';

    protected $fillable = ['titulo', 'descricao', 'data_abertura', 'data_fechamento', 'status'];

    public function orcamentos()
    {
        return $this->belongsToMany(Orcamento::class, 'chamada_publica_orcamentos')
                    ->withTimestamps(); // Relacionamento de muitos para muitos
    }
    public function orcamento()
{
    return $this->belongsTo(Orcamento::class);
}

    public function propostas()
    {
        return $this->hasMany(Proposta::class);
    }
    // No modelo ChamadaPublica
       // ChamadaPublica.php
       public function alimentos()
       {
           return $this->belongsToMany(Alimento::class, 'chamada_publica_alimento')
                       ->withTimestamps();
       }


}
