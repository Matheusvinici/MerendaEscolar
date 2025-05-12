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
        Schema::create('recebimento_anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recebimento_id')->constrained()->onDelete('cascade');
            $table->string('caminho_arquivo');
            $table->string('tipo');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recebimento_anexos');
    }
};
