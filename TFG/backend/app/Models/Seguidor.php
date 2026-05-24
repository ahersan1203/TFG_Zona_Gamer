<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seguidor extends Model
{
    protected $table = 'seguidores';    

    protected $fillable = ['usuario_id', 'usuario_seguido_id', 'estado'];
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function seguido()
    {
        return $this->belongsTo(User::class, 'usuario_seguido_id');
    }
}
