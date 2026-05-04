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
    Schema::create('equipos', function (Blueprint $table) {
        $table->id()->primary();

        $table->foreignId('cliente_id')
              ->constrained('clientes')
              ->cascadeOnDelete();

        $table->string('producto');
        $table->string('marca');
        $table->string('modelo')->nullable();
        $table->string('serial')->nullable()->unique();
        $table->text('descripcion')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
