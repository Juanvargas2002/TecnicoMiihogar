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
    Schema::create('imagenes_orden', function (Blueprint $table) {
        $table->id()->primary();

        $table->foreignId('orden_id')
              ->constrained('ordenes_servicio')
              ->cascadeOnDelete();

        //Usamos string para guardar rutas a una carpeta de almacenamiento, o incluso URLs si se almacenan en un servicio externo.
        $table->String('datos_imagen'); 
        $table->timestamps();
    });
}     
    public function down(): void
    {
        Schema::dropIfExists('imagenes_orden');
    }
};
