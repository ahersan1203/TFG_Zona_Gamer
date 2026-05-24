@extends ('layouts.comunidad')

@section('comunidad-content')
    <h1>Amigos</h1>
    <ul>
        @foreach ($amigos as $amigo)
            <li>
                <a href="{{ route('comunidad.showUsuario', $amigo->id) }}">
                    {{ $amigo->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection