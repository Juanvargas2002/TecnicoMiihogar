<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre',
        'documento',
        'email',
        'telefono',
        'direccion',
    ];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}
