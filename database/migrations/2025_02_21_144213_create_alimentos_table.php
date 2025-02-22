<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('unidade_medida'); // kg, litro, etc.
            $table->text('especificacao'); // kg, litro, etc.
            $table->string('periodicidade'); // kg, litro, etc.
            $table->decimal('valor_medio', 10, 2); // Preço médio do alimento
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alimentos');
    }
};
