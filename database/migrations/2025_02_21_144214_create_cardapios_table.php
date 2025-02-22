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
        Schema::create('cardapios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome'); // Nome do cardápio (ex: Cardápio Semanal)
            $table->float('quantidade_porcao_gr', 8, 2)->nullable(); // Quantidade por porção em gramas
            $table->float('quantidade_kg', 8, 2)->nullable(); // Quantidade total em kg
            $table->float('dias_servido', 8, 2)->nullable(); // Dias em que o cardápio será servido
            $table->integer('escola_id')->unsigned()->nullable(); // Relacionamento com a escola
            $table->foreign('escola_id')->references('id')->on('escolas')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cardapios');
    }
};