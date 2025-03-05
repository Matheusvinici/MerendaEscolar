<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('propostas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamada_publica_id')->constrained('chamadas_publicas')->onDelete('cascade');
            $table->unsignedBigInteger('regiao_id')->nullable(); // Mesmo tipo de dados que `id` em `regioes`
            $table->decimal('valor_total', 8, 2);
            $table->string('status')->default('pendente'); // Status da proposta
            $table->timestamps();

            // Adiciona a chave estrangeira após a criação da tabela
            $table->foreign('regiao_id')->references('id')->on('regioes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('propostas', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropForeign(['regiao_id']); // Remove a chave estrangeira
            $table->dropColumn('regiao_id'); // Remove a coluna
        });

        Schema::dropIfExists('propostas');
    }
};