{{-- resources/views/noticias/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Noticias</h1>

    <form method="GET" action="{{ route('noticias.index') }}">
    <select name="categoria_id">
        <option value="">Todas las categorías</option>

        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}"
                {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>

    <button type="submit">Filtrar</button>
</form>

    @if(auth()->user() && auth()->user()->rol->nombre == 'admin') 
        <a href="{{ route('noticias.create') }}">
            <button>Crear Noticia</button>
        </a>
    @endif

    <h2>Lista de Noticias</h2>

    @foreach ($noticias as $noticia)
        <div>
            <h2><a href="{{ route('noticias.show', $noticia) }}">{{ $noticia->titulo }}</a></h2>
            <p>{{ Str::limit($noticia->contenido, 50) }}</p>

            @if(auth()->user() && auth()->user()->rol->nombre == 'admin') 
                <a href="{{ route('noticias.edit', $noticia) }}">
                    <button>Editar</button>
                </a>
                <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta noticia?')">Eliminar</button>
                </form>
            @endif
        </div>
    @endforeach
@endsection