@extends('layouts.comunidad')

@section('comunidad-content')

<h1>Chat con {{ $usuario->name }}</h1>
<hr>

@foreach($mensajes as $mensaje)

    <div style="margin-bottom:10px;">

        @if($mensaje->emisor_id == auth()->id())
            <strong>Tú:</strong>
        @else
            <strong>{{ $usuario->name }}:</strong>
        @endif

        {{ $mensaje->contenido }}

    </div>
@endforeach

<hr>

<form action="{{ route('mensajesEnviar', $usuario->id) }}" method="POST">
    @csrf

    <input type="text" name="contenido" placeholder="Escribe un mensaje...">

    <button type="submit">Enviar</button>
</form>

@endsection