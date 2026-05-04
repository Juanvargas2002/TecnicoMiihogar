<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    use HasFactory;

    protected $table = 'ordenes_servicio';

    protected $fillable = [
        'numero_orden',
        'cliente_id',
        'equipo_id',
        'usuario_id',
        'estado',
        'accesorios',
        'falla_reportada',
        'diagnostico',
        'solucion',
        'observaciones',
        'fecha_recepcion',
        'fecha_entrega',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'orden_id');
    }
}
