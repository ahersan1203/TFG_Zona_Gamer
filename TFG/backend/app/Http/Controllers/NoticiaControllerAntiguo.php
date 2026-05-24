<?php

namespace App\Http\Controllers;
use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticiaControllerAntiguo extends Controller
{
    
    public function index(Request $request)
    {
        $categorias = Categoria::all();
        $query = Noticia::with(['categoria', 'usuario']);
        
        if ($request->filled('categoria_id')){
            $query->where('categoria_id', $request->categoria_id);  
        }
        $noticias = $query->latest()->paginate(10);

        return view('noticias.index', compact('noticias', 'categorias'));
    }

    public function show(Noticia $noticia)
    {
        return view('noticias.show', compact('noticia'));
    }

    public function create()
    {
       

        $categorias = Categoria::all();
        return view('noticias.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|mimetypes:image/jpeg,image/png,image/webp,image/avif|max:5120',
            'categoria_id' => 'required|exists:categorias,id',
        ]);
        $data['usuario_id'] = auth()->user()->id;
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
        $data['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }
        
        Noticia::create($data);
        return redirect()->route('noticias.index');
    }

    public function edit(Noticia $noticia)
    {
        

        $categorias = Categoria::all();
        return view('noticias.edit', compact('noticia', 'categorias'));
    }
public function update(Request $request, Noticia $noticia)
{
    

    $data = $request->validate([
        'titulo' => 'required|string|max:255',
        'contenido' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'categoria_id' => 'required|exists:categorias,id',
    ]);

    if ($request->hasFile('imagen')) {
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

    $noticia->update($data);

    return redirect()->route('noticias.index')->with('success', 'Noticia actualizada correctamente');
}

    public function destroy(Noticia $noticia)
    {
        
        $noticia->delete();
        return redirect()->route('noticias.index');
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
