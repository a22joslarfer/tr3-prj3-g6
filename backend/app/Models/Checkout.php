<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'user_id',
        'seat_id',
        'date',
        'unit_seat_price',
        'total'
    ];
}
