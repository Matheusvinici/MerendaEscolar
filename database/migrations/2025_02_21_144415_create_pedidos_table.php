<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escola_id')->constrained()->onDelete('cascade');
            $table->foreignId('cardapio_id')->nullable()->constrained()->onDelete('set null'); // Alterado para nullable
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('lote_id')->nullable();

            $table->date('data_inicio');
            $table->date('data_fim');
            $table->enum('status', ['pendente', 'processando', 'concluido', 'cancelado'])->default('pendente');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};