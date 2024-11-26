<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'oferta'; // Nombre de la tabla

    protected $primaryKey = 'OfertaID'; // Cambia 'OfertaID' por el nombre de la clave primaria
    public $incrementing = true; // Cambiar a false si no es autoincremental
    protected $keyType = 'int'; // Cambiar a 'string' si es alfanumérica

    protected $fillable = [
        'EmpresaID',
        'Título',
        'PrecioRegular',
        'PrecioOferta',
        'FechaInicio',
        'FechaFin',
        'FechaLimiteCanje',
        'CantidadCupones',
        'Descripción',
        'Estado',
    ];

    public $timestamps = true; // Manejo automático de created_at y updated_at
}
