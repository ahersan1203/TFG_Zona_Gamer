{{-- resources/views/noticias/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Crear Noticia</h1>
    <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" required>
        <br>
        <label for="contenido">Contenido</label>
        <textarea name="contenido" id="contenido" required></textarea>
        <br>
        <label for="categoria_id">Categoría</label>
        <select name="categoria_id" id="categoria_id">
            
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
        <br>
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" id="imagen">
        <br>
        <button type="submit">Crear Noticia</button>
    </form>
@endsection