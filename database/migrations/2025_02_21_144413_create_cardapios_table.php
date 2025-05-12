<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cardapios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->foreignId('escola_id')->constrained()->onDelete('cascade');
            $table->foreignId('segmento_id')->constrained()->onDelete('cascade');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->boolean('padrao')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cardapios');
    }
};