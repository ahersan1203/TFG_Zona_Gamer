@extends('layouts.app')

@section('content')

<div>

    <div>

        

        <div >
            <h1>{{ $user->name }}</h1>
            <p>{{ $user->email }}</p>
        </div>

    </div>
     @if(auth()->user()->rol_id == 1)

        <div style="display:flex; gap:15px; margin-top:20px;">

            <a href="{{ route('admin') }}"
               style="
               padding:10px 15px;
               background:#dc2626;
               color:white;
               text-decoration:none;
               border-radius:8px;
               ">
                🛡 Administrar
            </a>

        </div>

    @else
    @if(session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        @foreach($publicaciones as $publicacion)

            <div>
                <p>{{ $publicacion->contenido }}</p>
            </div>

            <div>

                <a href="{{ route('publicacion.editar', $publicacion->id) }}">
                    Editar
                </a>

                <form action="{{ route('publicacion.eliminar', $publicacion->id) }}"
                      method="POST"
                      style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            onclick="return confirm('¿Seguro que quieres borrar esta publicación?')">

                        🗑 Eliminar

                    </button>

                </form>

            </div>

        @endforeach

        <hr>

        @foreach($comentarios as $comentario)

            <div>
                <p>{{ $comentario->contenido }}</p>
            </div>
            <a href="{{ route('comentario.editar', $comentario->id) }}">
                    Editar
                </a>
            <form action="{{ route('comentario.eliminar', $comentario->id) }}"
                  method="POST">

                @csrf
                @method('DELETE')

                <button type="submit"
                        onclick="return confirm('¿Eliminar comentario?')">

                    🗑 Eliminar comentario

                </button>

            </form>

        @endforeach

    @endif

    <div  style="margin-top:40px;">

        <a href="{{ route('configuracion') }}"
               style="
               padding:10px 15px;
               background:#2563eb;
               color:white;
               text-decoration:none;
               border-radius:8px;
               ">
                ⚙ Configurar cuenta
            </a>
    </div>

</div>

@endsection