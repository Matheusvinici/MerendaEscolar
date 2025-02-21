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
        Schema::create('qualidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('observacao')->nullable();
            $table->string('condicao')->nullable();
            $table->string('atesto')->nullable();
            $table->integer('entrega_id')->unsigned()->nullable();
            $table->foreign('entrega_id')->references('id')->on('entregas');
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
        Schema::dropIfExists('qualidades');
    }
};
