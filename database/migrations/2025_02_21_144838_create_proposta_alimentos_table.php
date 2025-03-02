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
        Schema::create('proposta_alimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposta_id')->constrained()->onDelete('cascade');
            $table->foreignId('alimento_id')->constrained()->onDelete('cascade');
            $table->decimal('quantidade_ofertada', 8, 2); // Quantidade de alimento
            $table->decimal('valor_total', 10, 2); // Valor total do alimento na proposta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposta_alimentos');
    }
};
