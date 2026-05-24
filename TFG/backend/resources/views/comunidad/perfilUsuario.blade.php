@extends('layouts.comunidad')

@section('comunidad-content')

<h1>{{ $usuario->name }}</h1>

@if($usuario->id != auth()->id())
    <form action="{{ route('mensajesChat', $usuario->id) }}" method="GET">
        <button type="submit">Mensaje privado</button>
    </form>
@endif

<hr>

<h3>Publicaciones</h3>

@foreach($publicaciones as $pub)
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <p>{{ $pub->contenido }}</p>
    </div>
@endforeach

@endsection