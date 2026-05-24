{{-- resources/views/noticias/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Eventos</h1>


    @if(auth()->user() && auth()->user()->rol->nombre == 'admin') 
        <a href="{{ route('eventos.create') }}">
            <button>Crear Evento</button>
        </a>
    @endif

    <h2>Lista de Eventos</h2>

    @foreach ($eventos as $evento)
        <div>
            <h2><a href="{{ route('eventos.show', $evento) }}">{{ $evento->nombre }}</a></h2>
            <p>{{ Str::limit($evento->descripcion, 100) }}</p>

            @if(auth()->user() && auth()->user()->rol->nombre == 'admin') 
                <a href="{{ route('eventos.edit', $evento) }}">
                    <button>Editar</button>
                </a>
                <form action="{{ route('eventos.destroy', $evento) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este evento?')">Eliminar</button>
                </form>
            @endif
        </div>
    @endforeach
@endsection