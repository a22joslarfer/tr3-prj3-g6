<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class usuarioModel extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = ['nombre', 'password', 'email', 'phone', 'birthdate'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $table = 'usuarios';
}