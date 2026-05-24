@extends('layouts.app')
@section('content')
<h2>Configuración de Cuenta</h2>

        <form action="{{ route('perfilUpdate') }}" method="POST">

            @csrf
            @method('PUT')

            <div>
                <label>Nombre</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}">
            </div>

            <div>
                <label>Correo electrónico</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}">
            </div>

            <div>
                <label>Nueva contraseña</label>
                <input type="password" name="password">
            </div>

            <div>
                <label>Confirmar contraseña</label>
                <input type="password" name="password_confirmation">
            </div>

            <button type="submit">
                Guardar cambios
            </button>

        </form>

@endsection