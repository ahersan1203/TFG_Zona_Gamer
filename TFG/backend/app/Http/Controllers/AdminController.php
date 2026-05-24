<?php

namespace App\Http\Controllers;
use App\Models\Publicacion;
use App\Models\Evento;
use App\Models\Noticia;
use App\Models\Comentario;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
     public function apiPanel(Request $request)
    {

        return response()->json([
            'publicaciones' => Publicacion::all(),
            'usuarios' => User::all(),
            'eventos' => Evento::all(),
            'noticias' => Noticia::all(),
        ]);
    }
    public function apiEliminarPublicacion($id)
    {
        Publicacion::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Publicación eliminada'
        ]);
    }

    public function apiEliminarComentario($id)
    {
        Comentario::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Comentario eliminado'
        ]);
    }

    public function apiEliminarEvento($id)
    {
        Evento::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Evento eliminado'
        ]);
    }

    public function apiEliminarNoticia($id)
    {
        Noticia::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Noticia eliminada'
        ]);
    }

    public function apiEliminarUsuario($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado'
        ]);
    }
    public function apiActualizarUsuario(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'rol_id' => 'required'
        ]);

        $user->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'rol_id' => $request->rol_id
        ]);

        return response()->json([
            'data' => $user
        ]);
    }
    public function apiShowUsuario($id)
    {
        $usuario = User::findOrFail($id);

        return response()->json([
            'data' => $usuario
        ]);
    }
}
