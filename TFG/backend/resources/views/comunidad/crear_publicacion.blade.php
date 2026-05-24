<!-- fallos no encruentra la pagina de crear publicacion -->
@extends('layouts.comunidad')

@section('comunidad-content')
<h1>Crear Nueva Publicación</h1>

<form action="{{ route('comunidad.publicacion.guardar') }}" method="POST">
    @csrf
    <div>
        <textarea name="contenido" placeholder="Escribe tu publicación..." required>{{ old('contenido') }}</textarea>
        @error('contenido') <p style="color:red;">{{ $message }}</p> @enderror
    </div>

    <button type="submit">Publicar</button>
</form>

<a href="{{ route('comunidad.index') }}">Volver a la Comunidad</a>
@endsection