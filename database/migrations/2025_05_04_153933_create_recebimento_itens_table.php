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
        Schema::create('recebimento_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recebimento_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_pedido_id')->constrained('itens_pedido')->onDelete('cascade');            $table->decimal('quantidade_prevista', 10, 3);
            $table->decimal('quantidade_recebida', 10, 3);
            $table->decimal('diferenca', 10, 3);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recebimento_itens');
    }
};
