<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminControllerAntiguo extends Controller
{
     public function panel(Request $request)
    {
        return view('panelAdmin', [
            'publicaciones' => Publicacion::all(),
            'comentarios'   => Comentario::all(),
            'eventos'       => Evento::all(),
            'noticias'      => Noticia::all(),
        ]);
    }
}
