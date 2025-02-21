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
        Schema::create('propostas', function (Blueprint $table) {
            $table->increments('id');
            $table->float('quantidade', 8, 2);
            $table->float('valor_unitario', 8, 2);
            $table->float('valor_total', 8, 2);
            $table->date('data_entrega');
            $table->text('observacoes')->nullable();
            $table->enum('status', ['pendente', 'aprovada', 'recusada'])->default('pendente');
            $table->string('contrato')->nullable();
            $table->integer('item_id')->unsigned()->nullable();
            $table->foreign('item_id')->references('id')->on('itens');
            $table->integer('produtor_id')->unsigned()->nullable();
            $table->foreign('produtor_id')->references('id')->on('produtores');
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
        Schema::dropIfExists('propostas');
    }
};
