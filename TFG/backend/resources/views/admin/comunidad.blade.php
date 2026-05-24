<h2>📢 Comunidad</h2>

@foreach($publicaciones as $publicacion)

    <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">

        <p>{{ $publicacion->contenido }}</p>

        <form method="POST"
              action="{{ route('publicacion.eliminar', $publicacion->id) }}">

            @csrf
            @method('DELETE')

            <button onclick="return confirm('¿Eliminar publicación?')">
                🗑 Eliminar
            </button>

        </form>

    </div>

@endforeach
<hr>

@foreach($comentarios as $comentario)

    <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">

        <p>{{ $comentario->contenido }}</p>

        <small>
            En publicación: {{ $comentario->publicacion->contenido }}
        </small>

        <form method="POST"
              action="{{ route('comentario.eliminar', $comentario->id) }}">

            @csrf
            @method('DELETE')

            <button onclick="return confirm('¿Eliminar comentario?')">
                🗑 Eliminar comentario
            </button>

        </form>

    </div>

@endforeach