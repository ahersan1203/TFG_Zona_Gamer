<?php

namespace App\Http\Controllers;
use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    
    public function apiIndex(Request $request)
    {
        $query = Noticia::with(['categoria', 'usuario']);
        
        if ($request->filled('categoria_id')){
            $query->where('categoria_id', $request->categoria_id);  
        }

        $noticias = $query->latest()->paginate(10);
        $noticias->getCollection()->transform(function ($noticia) {
            $noticia->imagen_url = $noticia->imagen ? asset('storage/' . $noticia->imagen) : null;  
            return $noticia;
        });
        return response()->json($noticias);
    }

    public function apiShow(Noticia $noticia)
    {
        $noticia->imagen_url = $noticia->imagen ? asset('storage/' . $noticia->imagen) : null;
        return response()->json(['data' => $noticia->load(['categoria', 'usuario'])]);
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:5120',
            'categoria_id' => 'required|exists:categorias,id',
        ]);
        $data['usuario_id'] = auth()->user()->id;
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
        $data['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }
        
        $noticia = Noticia::create($data);
        $noticia->imagen_url = $noticia->imagen ? asset('storage/' . $noticia->imagen) : null;
        return response()->json([
        'message' => 'Noticia creada correctamente',
        'data' => $noticia]);
    }
public function apiUpdate(Request $request, Noticia $noticia)
{
    

    $data = $request->validate([
        'titulo' => 'required|string|max:255',
        'contenido' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:5120',
        'categoria_id' => 'required|exists:categorias,id',
    ]);

    if ($request->hasFile('imagen')) {
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

    $noticia->update($data);
    $noticia->load(['categoria', 'usuario']);
    $noticia->imagen_url = $noticia->imagen ? asset('storage/' . $noticia->imagen) : null;  

    return response()->json([
        'message' => 'Noticia actualizada correctamente',
        'data' => $noticia
    ]);
}

    public function apiDestroy(Noticia $noticia)
    {
        if ($noticia->imagen) {
            Storage::disk('public')->delete($noticia->imagen);
        }
        $noticia->delete();
        return response()->json([
            'message' => 'Noticia eliminada correctamente'
        ]);
    }

    // Buesqueda por categoria no funciona, se ha dejado comentada para no generar errores, se intentará arreglar en un futuro
    // public function busquedaCategoria(Request $request)
    // {
    //     $categoriaNombre = $request->input('categoria');
    //     $noticias = Noticia::whereHas('categoria', function ($query) use ($categoriaNombre) {
    //         $query->where('nombre', $categoriaNombre);
    //     })->get();
    //     return view('noticias.index', compact('noticias'));
    // }
}
