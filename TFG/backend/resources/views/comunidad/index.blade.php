@extends('layouts.comunidad')

@section('comunidad-content')

<div class="comunidad-container">

    <div class="comunidad-header">
        <h1>Comunidad</h1>

        <a href="{{ route('comunidad.publicacion.crear') }}">
            <button class="crear-post-btn">
                + Crear Nueva Publicación
            </button>
        </a>
    </div>

    @foreach($publicaciones as $pub)

        <div class="post-card">

            {{-- Header publicación --}}
            <div class="post-header">

                <div class="user-info">
                    <h3>{{ $pub->usuario->name }}</h3>
                    <span>{{ $pub->fecha }}</span>
                </div>

            </div>

            {{-- Contenido --}}
            <div class="post-content">

                <p>{{ $pub->contenido }}</p>

                @if($pub->imagen)
                    <img src="{{ asset('storage/' . $pub->imagen) }}"
                         alt="Imagen publicación"
                         class="post-image">
                @endif

            </div>

            {{-- Likes --}}
            <div class="post-actions">

                <form action="{{ route('comunidad.like', $pub->id) }}"
                      method="POST">

                    @csrf

                    <button type="submit" class="like-btn">

                        @if($pub->likes->contains('usuario_id', auth()->id()))
                            💔 Quitar Like
                        @else
                            ❤️ Like
                        @endif

                    </button>

                </form>

                <span class="likes-count">
                    {{ $pub->likes->count() }} likes
                </span>

            </div>

            {{-- Comentarios --}}
            <div class="comments-section">

                <h4>Comentarios</h4>

                @foreach($pub->comentarios as $comentario)

                    <div class="comment-card">

                        <strong>
                            {{ $comentario->usuario->name }}
                        </strong>

                        <p>
                            {{ $comentario->contenido }}
                        </p>

                    </div>

                @endforeach

            </div>

            {{-- Form comentario --}}
            <form action="{{ route('comunidad.comentar', $pub->id) }}"
                  method="POST"
                  class="comment-form">

                @csrf

                <input type="text"
                       name="contenido"
                       placeholder="Escribe un comentario..."
                       required>

                <button type="submit">
                    Comentar
                </button>

            </form>

        </div>

    @endforeach

</div>

@endsection