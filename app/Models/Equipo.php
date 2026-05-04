<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = [
        'cliente_id',
        'producto',
        'marca',
        'modelo',
        'serial',
        'descripcion',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ordenes()
    {
        return $this->hasMany(OrdenServicio::class, 'equipo_id');
    }
}
