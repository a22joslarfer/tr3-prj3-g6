<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discoModel extends Model
{
    use HasFactory;

    protected $fillable
        = ['coordenadas', 'imgUrl', 'minEdad', 'horario', 'nombre_local', 'telefono', 'descripcion'];
    protected $hidden = ['created_at', 'updated_at',];
    protected $table = 'discotecas';
}