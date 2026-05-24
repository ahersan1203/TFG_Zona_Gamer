{{-- resources/views/eventos/create.blade.php --}}
@extends('layouts.app')

@section('content')
<h1>Crear Evento</h1>

<form action="{{ route('eventos.store') }}" method="POST">
    @csrf

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>

    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" id="descripcion" required>{{ old('descripcion') }}</textarea>

    <label for="fecha_inicio">Fecha de inicio</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" required>

    <label for="fecha_final">Fecha final</label>
    <input type="date" name="fecha_final" id="fecha_final" value="{{ old('fecha_final') }}" required>

    <label for="lugar">Lugar</label>
    <input type="text" name="lugar" id="lugar" value="{{ old('lugar') }}" required>

    <button type="submit">Crear Evento</button>
</form>
@endsection