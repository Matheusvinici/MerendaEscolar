<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Executa as migrações.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incremento
            $table->unsignedBigInteger('escola_id'); // Chave estrangeira para a tabela `escolas`
            $table->unsignedBigInteger('proposta_id'); // Chave estrangeira para a tabela `propostas`
            $table->unsignedBigInteger('alimento_id'); // Chave estrangeira para a tabela `alimentos`
            $table->decimal('quantidade_pedida', 10, 2); // Quantidade pedida (em kg ou litros)
            $table->decimal('quantidade_entregue', 10, 2)->default(0); // Quantidade entregue (em kg ou litros)
            $table->date('data_pedido'); // Data do pedido
            $table->date('data_entrega'); // Data de entrega
            $table->timestamps(); // Colunas `created_at` e `updated_at`

            // Chaves estrangeiras
            $table->foreign('escola_id')->references('id')->on('escolas')->onDelete('cascade');
            $table->foreign('proposta_id')->references('id')->on('propostas')->onDelete('cascade');
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade');
        });
    }

    /**
     * Reverte as migrações.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
}