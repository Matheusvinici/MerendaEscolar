<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bairros', function (Blueprint $table) {
            $table->id(); // Coluna `id` do tipo `unsignedBigInteger`
            $table->string('nome')->nullable();
            $table->unsignedBigInteger('regiao_id'); // Chave estrangeira para a tabela `regioes`
            $table->timestamps();

            // Definindo a chave estrangeira
            $table->foreign('regiao_id')
                  ->references('id')
                  ->on('regioes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('bairros', function (Blueprint $table) {
            $table->dropForeign(['regiao_id']); // Remove a chave estrangeira
        });

        Schema::dropIfExists('bairros');
    }
};