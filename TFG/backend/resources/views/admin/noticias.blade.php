<h2>📰 Gestión de Noticias</h2>

<p>Listado de noticias:</p>

@foreach($noticias as $noticia)

    <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">

        <h3>{{ $noticia->titulo }}</h3>

        <p>{{ $noticia->contenido }}</p>

        <form method="PaOST"
              action="{{ route('noticias.destroy', $noticia->id) }}">

            @csrf
            @method('DELETE')

            <button onclick="return confirm('¿Eliminar noticia?')">
                🗑 Eliminar noticia
            </button>

        </form>

    </div>

@endforeach