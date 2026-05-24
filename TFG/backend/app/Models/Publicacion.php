<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    protected $table = 'publicaciones';
    protected $fillable = [ 'contenido', 'usuario_id', 'imagen', 'fecha', 'tipo'];
    public $timestamps = false;
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class, 'publicacion_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'publicacion_id');
    }

}
