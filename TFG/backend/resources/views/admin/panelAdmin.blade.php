@extends('layouts.app')

@section('content')

@php
    $section = request('section', 'comunidad');
@endphp

<div style="padding:30px;">

    <h1>🛡 Panel de Administración</h1>

    {{-- MENU SUPERIOR --}}
    <div style="display:flex; gap:15px; margin:20px 0;">

        <a href="{{ route('admin', ['section' => 'comunidad']) }}"
           style="padding:10px; background:#2563eb; color:white; border-radius:8px;">
            Comunidad
        </a>

        <a href="{{ route('admin', ['section' => 'eventos']) }}"
           style="padding:10px; background:#059669; color:white; border-radius:8px;">
            Eventos
        </a>

        <a href="{{ route('admin', ['section' => 'noticias']) }}"
           style="padding:10px; background:#d97706; color:white; border-radius:8px;">
            Noticias
        </a>

    </div>

    <hr>

    {{-- CONTENIDO DINAMICO --}}
    @if($section == 'comunidad')
        @include('admin.comunidad')
    @endif

    @if($section == 'eventos')
        @include('admin.eventos')
    @endif

    @if($section == 'noticias')
        @include('admin.noticias')
    @endif

</div>

@endsection