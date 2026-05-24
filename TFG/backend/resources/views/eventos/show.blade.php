{{-- resources/views/noticias/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>{{ $evento->nombre }}</h1>
    <p>{{ $evento->descripcion }}</p>
    <p><strong>Fecha de inicio:</strong> {{ $evento->fecha_inicio }}</p>
    <p><strong>Fecha final:</strong> {{ $evento->fecha_final }}</p>
    <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
@endsection