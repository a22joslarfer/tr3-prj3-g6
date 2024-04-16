<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviewModel extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'usuario_id',
        'disco_id',
        'titulo',
        'puntuacion',
        'content',
        'photo',

    ];
    protected $table = 'reviews';
}