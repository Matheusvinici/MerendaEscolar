<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('segmentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        // Inserir segmentos padrão
        DB::table('segmentos')->insert([
            ['nome' => 'Creche Parcial', 'descricao' => 'Educação Infantil - Creche Parcial', 'ativo' => true],
            ['nome' => 'Creche Integral', 'descricao' => 'Educação Infantil - Creche Integral', 'ativo' => true],
            ['nome' => 'Pré-escolar Parcial', 'descricao' => 'Educação Infantil - Pré-escolar Parcial', 'ativo' => true],
            ['nome' => 'Pré-escolar Integral', 'descricao' => 'Educação Infantil - Pré-escolar Integral', 'ativo' => true],
            ['nome' => 'Fundamental Parcial', 'descricao' => 'Ensino Fundamental - Parcial', 'ativo' => true],
            ['nome' => 'Fundamental Integral', 'descricao' => 'Ensino Fundamental - Integral', 'ativo' => true],
            ['nome' => 'EJA', 'descricao' => 'Educação de Jovens e Adultos', 'ativo' => true],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('segmentos');
    }
};