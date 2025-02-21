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
        Schema::create('financeiros', function (Blueprint $table) {
            $table->id();
            $table->float('gastos_anual', 8, 2);
            $table->float('gastos_semanal', 8, 2);
            $table->float('gastos_mensal', 8, 2);
            $table->float('investimento', 8, 2);
            $table->float('saldo_disponivel', 8, 2);
            $table->float('estoque', 8, 2);
            $table->integer('cardapio_id')->unsigned()->nullable();
            $table->foreign('cardapio_id')->references('id')->on('cardapios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiros');
    }
};
