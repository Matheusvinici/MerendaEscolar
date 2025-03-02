<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validacao extends Model
{
    use HasFactory;

    // Definir a tabela
    protected $table = 'validacaos';

    // Campos que podem ser preenchidos via mass-assignment
    protected $fillable = [
        'DAP_juridico',
        'alvara',
        'alvara_sanitario',
        'certidao_negativa_deb_municipio',
        'certidao_negativa_deb_estaduais',
        'certidao_concordata_falencia_recuperacao',
        'certidao_deb_credito_tribt_federal',
        'certidao_negativa_trabalhista',
        'fgts',
        'copia_estatuto_posse',
        'comprovante_end_cooperativa',
        'rg_cpf_representantes_legais',
        'comprovante_resd_representantes_legais',
        'decl_representante_controle_atendimento',
        'projeto_venda',
        'declaracao_gen_alimenticio_producao',
        'cert_prod_organica',
        'cert_prod_agroecologica',
        'regs_sanitario_alimentos',
        'audio_ajuda_url',  // URL do áudio explicativo
        'user_id',          // Relacionamento com o usuário
    ];

    // Relacionamento com o usuário (se necessário)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
