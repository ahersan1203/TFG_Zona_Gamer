<h2>Crear Cuenta</h2>

@if ($errors->any())
    <div class="auth-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/registro">
    @csrf

    <input type="text" name="name" placeholder="Nombre">

    <input type="email" name="email" placeholder="Email">

    <input type="password" name="password" placeholder="Contraseña">

    <input type="password" name="password_confirmation" placeholder="Repite contraseña">

    <button type="submit">Registrarse</button>
</form>

<a href="/login">¿Ya tienes cuenta? Inicia sesión</a>