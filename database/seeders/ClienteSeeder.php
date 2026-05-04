<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    
    use WithoutModelEvents;
    
    public function run(): void
    {
        Cliente::create([
            'nombre' => 'Jose Hernandez',
            'telefono' => '555-1234',
            'email' => 'jose.hernandez@example.com',
            'documento' => '123456789'
        ]);
        Cliente::create([
            'nombre' => 'Maria Garcia',
            'telefono' => '555-5678',
            'email' => 'maria.garcia@example.com',
            'documento' => '987654321'
        ]);
    }
}
