<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Nome do alimento
            $table->enum('unidade_medida', ['grama', 'ml']); // Unidade de medida
            $table->integer('pre_escola_qtd')->nullable(); // Quantidade por aluno - Pré-escola
            $table->integer('pre_escola_alunos')->nullable(); // Total de alunos - Pré-escola
            $table->integer('fundamental_qtd')->nullable(); // Quantidade por aluno - Fundamental
            $table->integer('fundamental_alunos')->nullable(); // Total de alunos - Fundamental
            $table->integer('eja_qtd')->nullable(); // Quantidade por aluno - EJA
            $table->integer('eja_alunos')->nullable(); // Total de alunos - EJA
            $table->integer('total_kg_litro')->nullable(); // Total de alunos - EJA

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alimentos');
    }
};
