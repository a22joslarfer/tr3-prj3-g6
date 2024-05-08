<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'nombre', // Asegúrate de ajustar esto según los campos de tu tabla
        // Otros campos de la tabla ciudad
    ];

    // Si tienes relaciones con otros modelos, puedes definirlas aquí
}
