@extends('layouts.app')

@section('content')

<div class="edit-post-container">

    <div class="edit-post-card">

        <h1>Editar comentario</h1>
        <form method="POST" action="{{ route('comentario.update', $comentario->id) }}">
            @csrf
            @method('PUT')

            <textarea name="contenido">{{ $comentario->contenido }}</textarea>

            <button type="submit">Guardar</button>
        </form>
</div>

</div>

@endsection