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


    public function getFriendsOfUser($userId)
    {
        return $this->where('seguidor', $userId)
            ->orWhere('seguido', $userId)
            ->whereExists(function ($query) use ($userId) {
                $query->selectRaw(1)
                    ->from('seguidores as f2')
                    ->whereColumn('f2.seguidor', 'seguidores.seguido')
                    ->whereColumn('f2.seguido', 'seguidores.seguidor')
                    ->where('f2.seguidor', $userId);
            })
            ->get('seguidor');
    }
}
