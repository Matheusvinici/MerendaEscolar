<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('unidade_medida');
            
            // Per capita por segmento
            $table->decimal('creche_parcial_per_capita', 8, 3)->default(0);
            $table->decimal('creche_integral_per_capita', 8, 3)->default(0);
            $table->decimal('pre_parcial_per_capita', 8, 3)->default(0);
            $table->decimal('pre_integral_per_capita', 8, 3)->default(0);
            $table->decimal('fundamental_parcial_per_capita', 8, 3)->default(0);
            $table->decimal('fundamental_integral_per_capita', 8, 3)->default(0);
            $table->decimal('eja_per_capita', 8, 3)->default(0);
            
            // Incidência por segmento
            $table->decimal('incidencia_creche_parcial', 5, 2)->default(1.00);
            $table->decimal('incidencia_creche_integral', 5, 2)->default(1.00);
            $table->decimal('incidencia_pre_parcial', 5, 2)->default(1.00);
            $table->decimal('incidencia_pre_integral', 5, 2)->default(1.00);
            $table->decimal('incidencia_fundamental_parcial', 5, 2)->default(1.00);
            $table->decimal('incidencia_fundamental_integral', 5, 2)->default(1.00);
            $table->decimal('incidencia_eja', 5, 2)->default(1.00);
            
            $table->boolean('disponivel_quinzena')->default(true);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alimentos');
    }
};
