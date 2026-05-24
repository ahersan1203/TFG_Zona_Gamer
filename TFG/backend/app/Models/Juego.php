<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $table = 'juegos';
    protected $fillable = ['nombre', 'desarrollador', 'genero', 'plataforma'];
    public $timestamps = false;
}
