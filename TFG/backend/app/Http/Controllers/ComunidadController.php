<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Publicacion;
use App\Models\Comentario;
use App\Models\Like;
use App\Models\Seguidor;
use App\Models\Mensaje;

class ComunidadController extends Controller
{
    public function apiIndex()
    {
        $publicaciones = Publicacion::with('usuario', 'comentarios.usuario', 'likes.usuario')
            ->orderBy('fecha', 'desc')
            ->get()
            ->map(function ($publicacion) {
                $publicacion->liked = $publicacion->likes->contains('usuario_id', auth()->id());
                $publicacion->likes_count = $publicacion->likes->count();
                return $publicacion;
            });
        return response()->json([
            'data' => $publicaciones
        ]);
    }

    public function apiShow($id)
    {
        $publicacion = Publicacion::with('usuario', 'comentarios.usuario', 'likes.usuario')
            ->findOrFail($id);

        return response()->json([
            'data' => $publicacion
        ]);
    }

    public function apiCrearPublicacion(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        $publicacion = Publicacion::create([
            'usuario_id' => auth()->id(),
            'contenido' => $request->contenido,
            'fecha' => now(),
        ]);

        return response()->json([
            'data' => $publicacion
        ]);
    }

    public function apiEliminarPublicacion($id)
    {
        $publicacion = Publicacion::findOrFail($id);

        $user = Auth::user();

        if (
            $publicacion->usuario_id !== $user->id &&
            $user->rol_id !== 1
        ) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $publicacion->delete();

        return response()->json([
            'message' => 'Publicación eliminada'
        ]);
    }

    public function apiActualizarPublicacion(Request $request, $id)
    {
        $publicacion = Publicacion::findOrFail($id);

        $user = Auth::user();

        if (
            $publicacion->usuario_id !== $user->id &&
            $user->rol_id !== 1
        ) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        $publicacion->update([
            'contenido' => $request->contenido
        ]);

        return response()->json([
            'data' => $publicacion
        ]);
    }

    public function apiLike($id)
    {
        $publicacion = Publicacion::findOrFail($id);

        $user = Auth::user();
        $like = Like::where('usuario_id', $user->id)
            ->where('publicacion_id', $id)
            ->first();

        if ($like) {
            $like->delete();

            return response()->json([
                'liked' => false,
                'likes_count' => Like::where('publicacion_id', $id)->count()
            ]);
        }

        Like::create([
            'usuario_id' => $user->id,
            'publicacion_id' => $id,
            'fecha' => now(),
        ]);

        return response()->json([
            'liked' => true,
            'likes_count' => Like::where('publicacion_id', $id)->count(),
        ]);
    }

    public function apiEliminarLike($id)
    {
        $like = Like::findOrFail($id);
        $like->delete();

        return response()->json([
            'message' => 'Like eliminado'
        ]);
    }

    public function apiComentar(Request $request, $id)
    {
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        $comentario = Comentario::create([
            'usuario_id' => auth()->id(),
            'publicacion_id' => $id,
            'contenido' => $request->contenido,
            'fecha' => now(),
        ]);

        return response()->json([
            'data' => $comentario
        ]);
    }

    public function apiEliminarComentario($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return response()->json([
            'message' => 'Comentario eliminado'
        ]);
    }

    public function apiActualizarComentario(Request $request, $id)
    {
        $comentario = Comentario::findOrFail($id);

        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        $comentario->update([
            'contenido' => $request->contenido
        ]);

        return response()->json([
            'data' => $comentario
        ]);
    }

    public function apiListadoUsuarios()
    {
        return response()->json([
            'data' => User::where('id', '!=', auth()->id())->get()
        ]);
    }


    public function apiShowUsuario($id)
    {
        $usuario = User::findOrFail($id);

        $publicaciones = Publicacion::with(
        'usuario',
        'comentarios.usuario',
        'likes.usuario'
    )
    ->where('usuario_id', $id)
    ->orderBy('fecha', 'desc')
    ->get();

    $yoSigo = Seguidor::where('usuario_id', auth()->id())
        ->where('usuario_seguido_id', $id)
        ->where('estado', 'aceptado')
        ->exists();

    $meSigue = Seguidor::where('usuario_id', $id)
        ->where('usuario_seguido_id', auth()->id())
        ->where('estado', 'aceptado')
        ->exists();

    return response()->json([
        'data' => [
            'usuario' => $usuario,
            'publicaciones' => $publicaciones,
            'amigos' => ($yoSigo && $meSigue)
        ]
    ]);
    }

    public function apiSeguir($id)
    {
        $seguidor = Seguidor::where('usuario_id', auth()->id())
            ->where('usuario_seguido_id', $id)
            ->first();

        if ($seguidor) {
            $seguidor->delete();

            return response()->json([
                'seguido' => false
            ]);
        }

        Seguidor::create([
            'usuario_id' => auth()->id(),
            'usuario_seguido_id' => $id,
            'estado' => 'pendiente',
        ]);

        return response()->json([
            'seguido' => true
        ]);
    }

    public function apiEliminarSeguido($id)
    {
        $seguidor = Seguidor::findOrFail($id);

        if($seguidor->usuario_id !== auth()->id()) {
            return response()->json([
                'message' => 'No autorizado'
            ], 403);
        }

        $seguidor->delete();

        return response()->json([
            'message' => 'Seguido eliminado'
        ]);
    }

    public function apiSolicitudes()
    {
        $solicitudes = Seguidor::with(['usuario'])
        ->where('usuario_seguido_id', auth()->id())
        ->where('estado', 'pendiente')
        ->get();

    return response()->json([
        'data' => $solicitudes
    ]);
    }

    public function apiAceptarSolicitud($id)
    {
        $solicitud = Seguidor::findOrFail($id);
        $solicitud->update(['estado' => 'aceptado']);

        return response()->json([
            'data' => $solicitud
        ]);
    }

    public function apiRechazarSolicitud($id)
    {
        $solicitud = Seguidor::findOrFail($id);
        $solicitud->update(['estado' => 'bloqueado']);

        return response()->json([
            'data' => $solicitud
        ]);
    }

    public function apiAmigos()
    {
        $user = auth()->user();

        $relaciones = Seguidor::with('usuario', 'seguido')
            ->where('estado', 'aceptado')
            ->where(function ($query) use ($user) {
                $query->where('usuario_id', $user->id)
                    ->orWhere('usuario_seguido_id', $user->id);
            })
            ->get();

        return response()->json([
            'data' => $relaciones
        ]);
    }
    public function apiChat($id)
    {
        $mensajes = Mensaje::with(['emisor', 'receptor'])
        ->where(function ($query) use ($id) {
            $query->where('emisor_id', auth()->id())
                ->where('receptor_id', $id);
        })
        ->orWhere(function ($query) use ($id) {
            $query->where('emisor_id', $id)
                ->where('receptor_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json([
            'data' => $mensajes
        ]);
    }

    public function apiEnviarMensaje(Request $request, $id)
    {
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        $mensaje = Mensaje::create([
            'emisor_id' => auth()->id(),
            'receptor_id' => $id,
            'contenido' => $request->contenido,
            'fecha' => now(),
        ]);

        return response()->json([
            'data' => $mensaje
        ]);
    }

    public function apiRelaciones()
    {
        return response()->json([
            'data' =>Seguidor::where('usuario_id', auth()->id())
            ->orWhere('usuario_seguido_id', auth()->id())
            ->get()
        ]);
    }
}