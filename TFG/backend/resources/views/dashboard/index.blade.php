<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <h1>Bienvenido al Dashboard</h1>
    <nav>
        <ul>
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
</body>
</html>