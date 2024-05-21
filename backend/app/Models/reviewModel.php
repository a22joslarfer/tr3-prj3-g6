<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
    use HasFactory;

    protected $table = 'reviews'; 

    protected $fillable = [
        'usuario_id',
        'disco_id',
        'titulo',
        'content',
        'puntuacion',
        'photo',
        'categoria',
    ];
}
