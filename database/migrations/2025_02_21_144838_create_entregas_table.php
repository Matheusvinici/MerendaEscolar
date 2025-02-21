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
        Schema::create('entregas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_entrega');
            $table->float('quantidade_entregue', 8, 2);
            $table->text('observacoes')->nullable();
            $table->integer('proposta_id')->unsigned()->nullable();
            $table->foreign('proposta_id')->references('id')->on('propostas');
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
        Schema::dropIfExists('entregas');
    }
};
