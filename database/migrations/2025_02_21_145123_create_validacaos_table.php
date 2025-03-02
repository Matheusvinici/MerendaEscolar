<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('validacaos', function (Blueprint $table) {
            $table->id();
            $table->string('DAP_juridico');
            $table->string('alvara');
            $table->string('alvara_sanitario');
            $table->string('certidao_negativa_deb_municipio');
            $table->string('certidao_negativa_deb_estaduais');
            $table->string('certidao_concordata_falencia_recuperacao');
            $table->string('certidao_deb_credito_tribt_federal');
            $table->string('certidao_negativa_trabalhista');
            $table->string('fgts');
            $table->string('copia_estatuto_posse');
            $table->string('comprovante_end_cooperativa');
            $table->string('rg_cpf_representantes_legais');
            $table->string('comprovante_resd_representantes_legais');
            $table->string('decl_representante_controle_atendimento');
            $table->string('projeto_venda');
            $table->string('declaracao_gen_alimenticio_producao');
            $table->string('cert_prod_organica')->nullable();
            $table->string('cert_prod_agroecologica')->nullable();
            $table->string('regs_sanitario_alimentos');
            $table->string('audio_ajuda_url')->nullable(); // Salvar o caminho do áudio
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validacaos');
    }
};
