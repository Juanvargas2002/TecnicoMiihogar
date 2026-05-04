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
    Schema::create('ordenes_servicio', function (Blueprint $table) {
        $table->id()->primary();

        $table->string('numero_orden')->unique();

        $table->foreignId('cliente_id')
              ->constrained('clientes');

        $table->foreignId('equipo_id')
              ->constrained('equipos');

        $table->foreignId('usuario_id')
              ->constrained('users');

        $table->enum('estado', ['Recibido', 'Diagnosticado', 'Reparado', 'Entregado'])->default('Recibido');
        $table->text('accesorios')->nullable();
        $table->text('falla_reportada');
        $table->text('diagnostico')->nullable();
        $table->text('solucion')->nullable();
        $table->text('observaciones')->nullable();

        $table->timestamp('fecha_recepcion')->nullable();
        $table->timestamp('fecha_entrega')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_servicio');
    }
};
