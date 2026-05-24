<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<div class="auth-container">
    <h1>Iniciar Sesión</h1>
    @if ($errors->any())
        <div class="auth-error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
    <p>¿No tienes cuenta? <a href="/registro">Registrarse</a></p>
    <p><a href="/olvideContrasena">¿Olvidaste tu contraseña?</a></p>
</div>