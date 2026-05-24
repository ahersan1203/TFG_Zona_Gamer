{{-- resources/views/noticias/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Editar Noticia</h1>
    <form action="{{ route('noticias.update', $noticia) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" value="{{ $noticia->titulo }}" required>

        <label for="contenido">Contenido</label>
        <textarea name="contenido" id="contenido" required>{{ $noticia->contenido }}</textarea>

        <label for="categoria_id">Categoría</label>
        <select name="categoria_id" id="categoria_id">
            
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>

        <button type="submit">Actualizar Noticia</button>
    </form>
@endsection