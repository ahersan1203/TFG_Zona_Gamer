@extends('layouts.comunidad')

@section('comunidad-content')
    <h1>Solicitudes pendientes</h1>
    @foreach ($solicitudes as $solicitud)
        <div>
            <p>{{ $solicitud->usuario->name }} quiere ser tu amigo</p>
            <form action="{{ route('comunidad.aceptarSolicitud', $solicitud) }}" method="POST">
                @csrf
                <input type="hidden" name="respuesta" value="aceptar">
                <button type="submit">Aceptar</button>
            </form>
            <form action="{{ route('comunidad.rechazarSolicitud', $solicitud) }}" method="POST">
                @csrf
                <input type="hidden" name="respuesta" value="rechazar">
                <button type="submit">Rechazar</button>
            </form>
        </div>
    @endforeach
@endsection