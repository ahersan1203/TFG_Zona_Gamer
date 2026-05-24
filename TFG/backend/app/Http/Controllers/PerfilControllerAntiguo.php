<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Publicacion;
use App\Models\Comentario;
use App\Models\Evento;
use App\Models\Noticia;
use Hash;

class PerfilControllerAntiguo extends Controller
{
    public function index()
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

        return view('perfil.index', compact(
            'user',
            'publicaciones',
            'comentarios'
        ));
    }

    public function update(Request $request){
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
        return redirect('/perfil')->with([
            'message' => 'Perfil actualizado correctamente',
            'type' => 'success'
        ]);
    }

    public function editarPublicacion($id){
        $publicacion = Publicacion::findOrFail($id);
        if($publicacion->usuario_id != Auth::user()->id){
            return redirect()->back();
        }
        return view('perfil.editarPublicacion', compact('publicacion'));
    }

    public function actualizarPublicacion(Request $request, $id){
        $publicacion = Publicacion::findOrFail($id);
        if($publicacion->usuario_id != Auth::user()->id){
            abort(403);
        }
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);
        $publicacion->contenido = $request->contenido;
        $publicacion->save();
        return redirect()->route('perfil.index')->with([
            'message' => 'Publicación actualizada correctamente',
            'type' => 'success'
        ]);
    }
    public function eliminarComentario($id)
    {
        $comentario = Comentario::findOrFail($id);
        if($comentario->usuario_id != Auth::user()->id){
            abort(403);
        }
        $comentario->delete();

        return redirect()->back();
    }

    public function eliminarPublicacion($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        if($publicacion->usuario_id != Auth::user()->id){
            abort(403);
        }
        $publicacion->delete();

        return redirect()->back();
    }
     public function admin(Request $request)
    {
        return view('admin.panelAdmin', [
            'publicaciones' => Publicacion::all(),
            'comentarios'   => Comentario::all(),
            'eventos'       => Evento::all(),
            'noticias'      => Noticia::all(),
        ]);
    }
    public function configuracion()
    {
        return view('perfil.configuracion', [
            'user' => auth()->user()
        ]);
    }
}
