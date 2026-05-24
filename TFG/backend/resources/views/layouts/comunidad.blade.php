@extends('layouts.app')

@section('content')

<div style="padding:10px; border-bottom:1px solid gray;">

    <a href="{{ route('comunidad.index') }}">
        Feed
    </a>

    |

    <a href="{{ route('comunidad.usuarios') }}">
        Usuarios
    </a>

    |

    <a href="{{ route('comunidad.solicitudes') }}">
        Solicitudes
    </a>
    
    |

    <a href="{{ route('comunidadAmigos') }}">
        Amigos
    </a>

</div>

<div style="padding:20px;">

    @yield('comunidad-content')

</div>

@endsection