<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Publicacion;
use App\Models\Comentario;
use App\Models\Evento;
use App\Models\Noticia;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function apiIndex()
    {
        $user = Auth::user();
        $publicaciones = Publicacion::with('likes', 'comentarios')
        ->where('usuario_id', $user->id)
        ->OrderBy('fecha', 'desc')
        ->get();
         
        $comentarios = Comentario::with('publicacion')
        ->where('usuario_id', $user->id)
        ->orderBy('fecha', 'desc')
        ->get();

        return response()->json([
            'user' => $user,
            'publicaciones' => $publicaciones,
            'comentarios' => $comentarios
        ]);
    }

    public function apiUpdate(Request $request){
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password= Hash::make($request->password);
        }
        $user->save();
        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user' => $user
        ]);
    }

    public function apiEditarPublicacion($id){
        $publicacion = Publicacion::findOrFail($id);
        if($publicacion->usuario_id != Auth::user()->id){
            return response()->json([
                'error' => 'No autorizado'
            ], 403);
        }
        return response()->json([
            'data' => $publicacion
        ]);
    }

    public function apiActualizarPublicacion(Request $request, $id){
        $publicacion = Publicacion::findOrFail($id);
        if($publicacion->usuario_id != Auth::user()->id){
            return response()->json([
                'error' => 'No autorizado'
            ], 403);
        }
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);
        $publicacion->contenido = $request->contenido;
        $publicacion->save();
        return response()->json([
            'message' => 'Publicación actualizada correctamente',
            'data' => $publicacion  
        ]);
        }
    public function apiEliminarComentario($id)
    {
        $comentario = Comentario::findOrFail($id);
        if($comentario->usuario_id != Auth::user()->id){
            return response()->json([
                'error' => 'No autorizado'
            ], 403);
        }
        $comentario->delete();

        return response()->json([
            'message' => 'Comentario eliminado',
        ]);
    }

    public function apiEliminarPublicacion($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        if($publicacion->usuario_id != Auth::user()->id){
            return response()->json([
                'error' => 'No autorizado'
            ], 403);
        }
        $publicacion->delete();

        return response()->json([
            'message' => 'Publicación eliminada'
        ]);
    }
     public function apiAdmin(Request $request)
    {
        if(Auth::user()->rol_id != 1){
            return response()->json([
                'error' => 'No autorizado'
            ],403);
        }
        return response()->json([
            'publicaciones' => Publicacion::all(),
            'comentarios' => Comentario::all(),
            'eventos' => Evento::all(),
            'noticias' => Noticia::all(),
        ]);
    }
    public function apiConfiguracion()
    {
        return response()->json([
            'user' => auth()->user()
        ]);
    }
}
