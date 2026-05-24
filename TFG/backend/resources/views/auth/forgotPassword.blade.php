<h2>Recuperar contraseña</h2>

<form method="POST" action="/olvideContrasena">
    @csrf

    <input type="email" name="email" placeholder="Tu email">

    <button type="submit">Enviar</button>
</form>