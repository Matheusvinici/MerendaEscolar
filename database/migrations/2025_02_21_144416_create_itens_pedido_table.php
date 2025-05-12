<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itens_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
            $table->foreignId('alimento_id')->constrained()->onDelete('cascade');
            $table->decimal('quantidade', 10, 3);
            $table->string('unidade_medida', 20);
            
            // Incidências por segmento
            $table->decimal('incidencia_creche_parcial', 5, 2)->default(1.00);
            $table->decimal('incidencia_creche_integral', 5, 2)->default(1.00);
            $table->decimal('incidencia_pre_parcial', 5, 2)->default(1.00);
            $table->decimal('incidencia_pre_integral', 5, 2)->default(1.00);
            $table->decimal('incidencia_fundamental_parcial', 5, 2)->default(1.00);
            $table->decimal('incidencia_fundamental_integral', 5, 2)->default(1.00);
            $table->decimal('incidencia_eja', 5, 2)->default(1.00);
            
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itens_pedido');
    }
};