<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seguidorModel extends Model
{
    use HasFactory;

    protected $fillable = ['seguidor', 'seguido'];

    protected $table = 'seguidores';

    public $timestamps = false;



    public function seguidores()
    {
        return $this->belongsTo(User::class, 'seguidor', 'id');
    }

    public function seguidos()
    {
        return $this->belongsTo(User::class, 'seguido', 'id');
    }


   
}
