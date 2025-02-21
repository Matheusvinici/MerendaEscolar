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
        Schema::create('alimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->nullable();
            $table->float('quantidade_porcao_gr', 8, 2)->nullable();
            $table->float('quantidade_kg', 8, 2)->nullable();
            $table->float('dias_servido', 8, 2)->nullable();
            $table->float('total_adquirido', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};
