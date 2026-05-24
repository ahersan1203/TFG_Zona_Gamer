@extends('layouts.app')

@section('content')

<div class="edit-post-container">

    <div class="edit-post-card">

        <h1>Editar publicación</h1>

        <form action="{{ route('publicacion.actualizar', $publicacion->id) }}" method="POST">

            @csrf
            @method('PUT')

            <textarea name="contenido" rows="6">
{{ old('contenido', $publicacion->contenido) }}
            </textarea>

            <button type="submit">
                Guardar cambios
            </button>

        </form>

    </div>

</div>

@endsection
