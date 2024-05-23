<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inTime extends Model
{
    use HasFactory;

    protected $fillable = [
      'img_del',
      'img_tra',
      'id_usuari',
      'hora'
  ];
  protected $table ='bereal';

}
