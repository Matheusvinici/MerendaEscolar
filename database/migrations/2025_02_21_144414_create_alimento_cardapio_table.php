<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alimento_cardapio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cardapio_id')->constrained()->onDelete('cascade');
            $table->foreignId('alimento_id')->constrained()->onDelete('cascade');
            $table->enum('dia_semana', ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'])->nullable();
            $table->enum('refeicao', ['cafe_manha', 'lanche', 'almoco', 'lanche_tarde', 'jantar'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alimento_cardapio');
    }
};