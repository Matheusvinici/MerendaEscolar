<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Criação da tabela 'orcamentos'
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao'); // Descrição do orçamento
            $table->date('data_inicio'); // Data de início de validade
            $table->date('data_fim'); // Data de fim de validade
            $table->integer('dias_letivos'); // Quantidade de dias letivos
            $table->decimal('total', 8, 2)->nullable(); // Adicionando a coluna 'total'
            $table->timestamps();
        });
        
        // Criação da tabela 'orcamento_alimentos'
        Schema::create('orcamento_alimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orcamento_id')->constrained('orcamentos')->onDelete('cascade');
            $table->foreignId('alimento_id')->constrained('alimentos')->onDelete('cascade');
            $table->decimal('valor_medio', 8, 2); // Valor médio do alimento
            $table->decimal('custo_total', 8, 2)->nullable(); // Custo total do alimento
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Remove as tabelas ao reverter a migration
        Schema::dropIfExists('orcamento_alimentos');
        Schema::dropIfExists('orcamentos');
    }
};
