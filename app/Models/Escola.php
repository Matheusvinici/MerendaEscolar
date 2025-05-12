<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'codigo_inep'];

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }
}