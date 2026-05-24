{{-- resources/views/noticias/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>{{ $noticia->titulo }}</h1>
    <p>{{ $noticia->contenido }}</p>
@endsection