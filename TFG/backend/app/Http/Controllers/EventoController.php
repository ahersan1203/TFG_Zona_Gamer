<?php

namespace App\Http\Controllers;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function apiIndex()
    {
        return response()->json(Evento::all());
    }

    public function apiShow($id)
    {
        $evento = Evento::findOrFail($id);

        return response()->json($evento);
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date',
            'lugar' => 'required|string|max:255',
        ]);
        
        

        $evento = Evento::create($data);
        return response()->json([
            'message' => 'Evento creado correctamente',
            'evento' => $evento
        ], 201);
    }
    public function apiUpdate(Request $request, Evento $evento)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date',
            'lugar' => 'required|string|max:255',
        ]);

        $evento->update($data);

        return response()->json([
            'message' => 'Evento actualizado correctamente',
            'evento' => $evento
        ]);
    }

    public function apiDestroy(Evento $evento)
    {
        $evento->delete();
        return response()->json([
            'message' => 'Evento eliminado correctamente'
        ]);
    }
}
