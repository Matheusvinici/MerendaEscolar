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
        Schema::create('chamadas_publicas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // Nome da chamada pública
            $table->text('descricao'); // Descrição detalhada
            $table->date('data_abertura'); // Data de abertura
            $table->date('data_fechamento'); // Data de fechamento
            $table->enum('status', ['aberta', 'encerrada', 'finalizada']); // Status da chamada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamadas_publicas');
    }
};
