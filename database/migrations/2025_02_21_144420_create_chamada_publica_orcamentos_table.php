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
        Schema::create('chamada_publica_orcamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamada_publica_id')->constrained('chamadas_publicas')->onDelete('cascade');
            $table->foreignId('orcamento_id')->constrained('orcamentos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamada_publica_orcamentos');
    }
};
