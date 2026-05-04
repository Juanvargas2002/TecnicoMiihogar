<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipo;

class EquipoSeeder extends Seeder
{


    public function run(): void
    {
        Equipo::create([
            'cliente_id' => 2,
            'producto' => 'Laptop',
            'marca' => 'Dell',
            'modelo' => 'XPS 13',
            'serial' => 'ABC123456',
            'descripcion' => 'Laptop con pantalla táctil y procesador Intel i7.'
        ]);

        Equipo::create([
            'cliente_id' => 1,
            'producto' => 'Smartphone',
            'marca' => 'Samsung',
            'modelo' => 'Galaxy S21',
            'serial' => 'XYZ987654',
            'descripcion' => 'Smartphone con cámara de alta resolución y batería de larga duración.'
        ]);
    }
}
