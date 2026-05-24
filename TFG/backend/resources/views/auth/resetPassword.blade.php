<h2>Recuperar contraseña</h2>
<form method="POST" action="/resetearContrasena">
    @csrf

    <input type="password" name="password" placeholder="Nueva contraseña">

    <input type="password" name="password_confirmation" placeholder="Repite contraseña">

    <button type="submit">Cambiar contraseña</button>
</form>