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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('modalidade_ensino')->nullable();
            $table->integer('alunos_senso')->nullable();
            $table->integer('dias_letivos')->nullable();
            $table->integer('valor_dia_aluno')->nullable();
            $table->float('valor_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
