<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escolas', function (Blueprint $table) {
            $table->id(); // Coluna `id` do tipo `unsignedBigInteger`
            $table->string('nome')->nullable();
            $table->string('inep')->nullable();
            $table->unsignedBigInteger('bairro_id'); // Chave estrangeira para a tabela `bairros`
            $table->integer('pre_escola_alunos')->nullable(); // Quantidade de alunos na pré-escola
            $table->integer('fundamental_alunos')->nullable(); // Quantidade de alunos no fundamental
            $table->integer('eja_alunos')->nullable(); // Quantidade de alunos no EJA
            $table->timestamps();

            // Definindo a chave estrangeira
            $table->foreign('bairro_id')
                  ->references('id')
                  ->on('bairros')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('escolas', function (Blueprint $table) {
            $table->dropForeign(['bairro_id']); // Remove a chave estrangeira
        });

        Schema::dropIfExists('escolas');
    }
};