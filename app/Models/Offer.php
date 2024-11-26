<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    // Especificar la tabla personalizada
    protected $table = 'oferta';

    // Campos asignables en masa
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

    // Relación: Una oferta pertenece a un usuario (empresa)
    public function user()
    {
        return $this->belongsTo(User::class, 'EmpresaID');
    }
}
