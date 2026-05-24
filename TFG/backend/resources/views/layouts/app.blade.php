<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    
    <header>
        <nav>
            <ul>
                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ url('/noticias') }}">Noticias</a></li>
                <li><a href="{{ url('/comunidad') }}">Comunidad</a></li>
                <li><a href="{{ url('/eventos') }}">Eventos</a></li>
                <li><a href="{{ url('/perfil') }}">Perfil</a></li>
                <li>
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    
    <main>
        @yield('content')
    </main>

    
</body>
</html>