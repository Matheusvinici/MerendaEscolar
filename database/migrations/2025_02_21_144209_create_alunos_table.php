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
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escola_id')->constrained();
            
            // Quantidade de alunos por segmento
            $table->integer('creche_parcial')->default(0);
            $table->integer('creche_integral')->default(0);
            $table->integer('pre_parcial')->default(0);
            $table->integer('pre_integral')->default(0);
            $table->integer('fundamental_parcial')->default(0);
            $table->integer('fundamental_integral')->default(0);
            $table->integer('eja')->default(0);
            
            $table->string('ano_letivo', 9);
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
