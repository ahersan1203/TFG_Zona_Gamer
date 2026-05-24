<?php

namespace App\Http\Controllers;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoControllerAntiguo extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
    }

    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date',
            'lugar' => 'required|string|max:255',
        ]);
        
        

        Evento::create($data);
        return redirect()->route('eventos.index');
    }

    public function edit(Evento $evento)
    {
        
        return view('eventos.edit', compact('evento'));
    }
public function update(Request $request, Evento $evento)
{
    $data = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'fecha_inicio' => 'required|date',
        'fecha_final' => 'required|date',
        'lugar' => 'required|string|max:255',
    ]);

    $evento->update($data);

    return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente');
}

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index');
    }
}
