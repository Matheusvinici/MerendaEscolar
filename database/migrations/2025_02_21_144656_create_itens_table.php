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
        Schema::create('itens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_item');
            $table->float('quantidade', 8, 2);
            $table->string('unidade_medida');
            $table->date('data_limite');
            $table->text('observacoes')->nullable();
            $table->integer('chamada_id')->unsigned()->nullable();
            $table->foreign('chamada_id')->references('id')->on('chamadas');
            $table->integer('escola_id')->unsigned()->nullable();
            $table->foreign('escola_id')->references('id')->on('escolas');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens');
    }
};
