<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Publicacion;
use App\Models\Comentario;
use App\Models\Like;
use App\Models\Seguidor;
use App\Models\Mensaje;

class ComunidadControllerAntigua extends Controller
{
    public function index()
    {
        $user = auth()->user(); 
        
        //publicaciones de los usuarios 
        $publicaciones = Publicacion::with('usuario', 'comentarios.usuario', 'likes.usuario')
            ->orderBy('fecha', 'desc')
            ->get();

        

       
        return view('comunidad.index', compact('publicaciones'));
    }

    public function show($id)
    {
        $publicacion = Publicacion::with('usuario', 'comentarios.usuario', 'likes.usuario')->findOrFail($id);
        return view('comunidad.show', compact('publicacion'));
    }

    public function like($id)
    {
        $user = auth()->user();
        $publicacion = Publicacion::findOrFail($id);

        // Verificar si el usuario ya ha dado like a esta publicación
        $likeExistente = Like::where('usuario_id', $user->id)
            ->where('publicacion_id', $publicacion->id)
            ->first();

        if ($likeExistente) {
            // Si ya existe, eliminar el like (deshacer el like)
            $likeExistente->delete();
        } else {
            // Si no existe, crear un nuevo like
            Like::create([
                'usuario_id' => $user->id,
                'publicacion_id' => $publicacion->id,
                'fecha' => now(),
            ]);
        }

        return redirect()->back();
    }

    public function comentar(Request $request, $id)
    {
        $user = auth()->user();
        $publicacion = Publicacion::findOrFail($id);

        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        Comentario::create([
            'usuario_id' => $user->id,
            'publicacion_id' => $publicacion->id,
            'contenido' => $request->input('contenido'),
            'fecha' => now(),
        ]);

        return redirect()->back();
    }

    public function edit(Comentario $comentario)
    {
        return view('perfil.editarComentario', compact('comentario'));
    }

    public function update(Request $request, Comentario $comentario)
    {
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]); 

        $comentario->contenido = $request->input('contenido');
        $comentario->save();

        return redirect()->route('perfilIndex');
    }   

    public function seguir($id)
    {
        $user = auth()->user();
        $usuarioASeguir = User::findOrFail($id);

        // Verificar si ya sigo a este usuario
        $seguimientoExistente = Seguidor::where('usuario_id', $user->id)
            ->where('usuario_seguido_id', $usuarioASeguir->id)
            ->first();

        if ($seguimientoExistente) {
            // Si ya existe, eliminar el seguimiento (dejar de seguir)
            $seguimientoExistente->delete();
        } else {
            // Si no existe, crear un nuevo seguimiento
            Seguidor::create([
                'usuario_id' => $user->id,
                'usuario_seguido_id' => $usuarioASeguir->id,
            ]);
        }

        return redirect()->back();
    }

    public function seguidores($id)
    {
        $usuario = User::findOrFail($id);
        $seguidores = Seguidor::with('usuario')
            ->where('usuario_seguido_id', $usuario->id)
            ->get();

        return view('comunidad.seguidores', compact('usuario', 'seguidores'));
    }

    public function seguidos($id)
    {
        $usuario = User::findOrFail($id);
        $seguidos = Seguidor::with('seguido')
            ->where('usuario_id', $usuario->id)
            ->get();

        return view('comunidad.seguidos', compact('usuario', 'seguidos'));
    }   

    public function eliminarLike($id)
    {
        $like = Like::findOrFail($id);
        $like->delete();

        return redirect()->back();
    }

    public function eliminarSeguidor($id)
    {
        $seguidor = Seguidor::findOrFail($id);
        $seguidor->delete();

        return redirect()->back();
    }

    public function eliminarSeguido($id)
    {
        $seguidor = Seguidor::findOrFail($id);
        $seguidor->delete();

        return redirect()->back();
    }   
    
    public function crearPublicacion()
    {
        return view('comunidad.crear_publicacion');
    }

    public function guardarPublicacion(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        Publicacion::create([
            'usuario_id' => auth()->user()->id,
            'contenido' => $request->input('contenido'),
            'fecha' => now(),
        ]);

        return redirect()->route('comunidad.index');
    }
    public function editarPublicacion($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        if ($publicacion->usuario_id != auth()->id()) {
            abort(403);
        }

        return view( 'perfil.editarPublicacion', compact('publicacion'));
    }

    public function actualizarPublicacion(Request $request, $id)
    {
        $publicacion = Publicacion::findOrFail($id);
        if ($publicacion->usuario_id != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        $publicacion->contenido = $request->input('contenido');
        $publicacion->save();

        return redirect()->route('perfilIndex')
            ->with('success', 'Publicación actualizada correctamente');

    }
    public function listadoUsuarios()
    {
        $user = auth()->user();
        $usuarios = User::where('id', '!=', $user->id)->get();

        $seguidores = Seguidor::where('usuario_id', $user->id)
            ->get()
            ->keyBy('usuario_seguido_id');
        return view('comunidad.usuariosLista', ['usuarios' => $usuarios, 'seguidores' => $seguidores]);
    }
    public function showUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $publicaciones = Publicacion::with('usuario', 'comentarios.usuario', 'likes.usuario')
            ->where('usuario_id', $id)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('comunidad.perfilUsuario', compact('usuario', 'publicaciones'));
    }
    public function enviarSolicitud($id)
    {
        $user = auth()->user();
        $existe = Seguidor::where('usuario_id', $user->id)
            ->where('usuario_seguido_id', $id)
            ->first();

        if (!$existe) {
            Seguidor::create([
                'usuario_id' => $user->id,
                'usuario_seguido_id' => $id,
                'estado' => 'pendiente',
            ]);
        }

        return redirect()->back();
    }

    public function verSolicitudes()
    {
        $solicitudes = Seguidor::with('usuario')
            ->where('usuario_seguido_id', auth()->user()->id)
            ->where('estado', 'pendiente')
            ->get();

        return view('comunidad.solicitudes', compact('solicitudes'));
    }

    public function aceptarSolicitud($id)
    {
        $solicitud = Seguidor::findOrFail($id);
        $solicitud->estado = 'aceptado';
        $solicitud->save();

        return redirect()->back();
    }

    public function rechazarSolicitud($id)
    {
        $solicitud = Seguidor::findOrFail($id);
        $solicitud->estado = 'bloqueado';
        $solicitud->save();

        return redirect()->back();
    }  

    public function amigos(){
        $user = auth()->user();

        $relaciones = Seguidor::with('usuario', 'seguido')
            ->where('estado', 'aceptado')
            ->where(function ($query) use ($user) {
                $query->where('usuario_id', $user->id)
                    ->orWhere('usuario_seguido_id', $user->id);
            })
            ->get()
            ->unique(function ($relacion) use ($user) {
                return $relacion->usuario_id === $user->id 
                ? $relacion->usuario_seguido_id 
                : $relacion->usuario_id;
            });

            $amigos = $relaciones->map(function ($relacion) use ($user) {
                return $relacion->usuario_id === $user->id 
                ? $relacion->seguido 
                : $relacion->usuario;
            });
            return view('comunidad.Amigos', compact('amigos'));
        
    }

    public function chat($id)
    {
        $usuario = User::findOrFail($id);

        $mensajes = Mensaje::where(function ($query) use ($id) {
            $query->where('emisor_id', auth()->id())
                ->where('receptor_id', $id);
        })
         ->orWhere(function ($query) use ($id) {
        $query->where('emisor_id', $id)
            ->where('receptor_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->get();
        return view('comunidad.chat', compact('usuario', 'mensajes'));
    }

    public function enviarMensaje(Request $request, $id){
        $request->validate([
            'contenido' => 'required'
        ]);

        Mensaje::create([
             'emisor_id' => auth()->id(),
            'receptor_id' => $id,
            'contenido' => $request->contenido,
            'fecha' => now()
        ]);
        return back();
    }
}
