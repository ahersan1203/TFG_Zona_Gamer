<h2>📅 Gestión de Eventos</h2>

<p>Listado de eventos:</p>

@foreach($eventos as $evento)

    <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">

        <h3>{{ $evento->titulo }}</h3>

        <p>{{ $evento->descripcion }}</p>

        <form method="POST"
              action="{{ route('eventos.destroy', $evento->id) }}">

            @csrf
            @method('DELETE')

            <button onclick="return confirm('¿Eliminar evento?')">
                🗑 Eliminar evento
            </button>

        </form>

    </div>

@endforeach