@extends('layouts.comunidad')

@section('comunidad-content')
    <h1>Lista de Usuarios</h1>
    <ul>  
        @foreach ($usuarios as $usuario)
            <li>
                <a  href="{{ route('comunidad.showUsuario', $usuario->id) }}">
                    {{ $usuario->name }}
                </a>
                @if(!isset($seguidores[$usuario->id]))
                    <form action="{{ route('comunidad.enviarSolicitud', $usuario->id) }}" method="POST">
                        @csrf
                        <button>Enviar solicitud</button>
                    </form>

                @elseif($seguidores[$usuario->id]->estado == 'pendiente')
                    <button disabled>Solicitud enviada</button>

                @elseif($seguidores[$usuario->id]->estado == 'aceptado')
                    <button disabled>Amigos ✔</button>
                @endif
            </li>
        @endforeach
        
    </ul>
@endsection