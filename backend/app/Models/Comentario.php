<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_bereal',
        'comentario',
        'id_usuari',
        'hora',
        'autor',
        'like',
    ];
}
