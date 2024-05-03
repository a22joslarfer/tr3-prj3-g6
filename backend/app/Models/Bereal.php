<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bereal extends Model
{
    use HasFactory;

    protected $fillable = [
      'img_del',
      'img_tra',
      'id_usuari'
  ];
  protected $table ='bereal';

}
