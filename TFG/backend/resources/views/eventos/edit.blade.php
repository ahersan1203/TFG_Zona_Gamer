{{-- resources/views/eventos/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Editar Evento</h1>
    <form action="{{ route('eventos.update', $evento) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="{{ $evento->nombre }}" required>

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" required>{{ $evento->descripcion }}</textarea>

        <label for="fecha_inicio">Fecha de inicio</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $evento->fecha_inicio }}" required>

        <label for="fecha_final">Fecha final</label>
        <input type="date" name="fecha_final" id="fecha_final" value="{{ $evento->fecha_final }}" required>

        <label for="lugar">Lugar</label>
        <input type="text" name="lugar" id="lugar" value="{{ $evento->lugar }}" required>

        <button type="submit">Actualizar Evento</button>
    </form>
@endsection