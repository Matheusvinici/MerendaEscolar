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
     // Migration para criar a tabela 'propostas'
        Schema::create('propostas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamada_publica_id')->constrained('chamadas_publicas')->onDelete('cascade');
            $table->decimal('valor_total', 8, 2); // Valor total da oferta (quantidade * preço unitário)
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propostas');
    }
};
