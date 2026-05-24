<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $fillable = ['nombre', 'descripcion', 'fecha_inicio', 'fecha_final', 'lugar'];
    public $timestamps = false;
}

