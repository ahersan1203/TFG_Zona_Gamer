<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/registro', [AuthController::class, 'register']);
Route::get('/olvideContrasena', [AuthController::class, 'showForgotPasswordForm']);
Route::post('/olvideContrasena', [AuthController::class, 'sendResetLink']);
Route::get('/resetearContrasena', [AuthController::class, 'showResetPasswordForm']);
Route::post('/resetearContrasena', [AuthController::class, 'resetPassword']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');


Route::middleware('auth')->group(function(){
    Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
    //Comento la busqueda por categoria porque no funciona, se intentará arreglar en un futuro, pero de momento no es una funcionalidad esencial
    Route::get('/noticias/search', [NoticiaController::class, 'busquedaCategoria'])->name('noticias.search');
    Route::middleware('admin')->group(function() {
        Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
        Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store');
        Route::get('/noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit');
        Route::put('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');
        Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
    });
    Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');
});

Route::middleware('auth')->group(function(){
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
    Route::middleware('admin')->group(function() {
        Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create');
        Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
        Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
        Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');
        Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');
    });
    Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');
});

Route::middleware('auth')->group(function() {
    Route::get('/comunidad', [ComunidadController::class, 'index'])->name('comunidad.index');
    Route::get('/comunidad/publicacion/crear', [ComunidadController::class, 'crearPublicacion'])->name('comunidad.publicacion.crear');
    Route::post('/comunidad/publicacion/guardar', [ComunidadController::class, 'guardarPublicacion'])->name('comunidad.publicacion.guardar');
    Route::get('/comunidad/publicacion/{id}', [ComunidadController::class, 'show'])->name('comunidad.show');
    Route::post('/comunidad/publicacion/{id}/like', [ComunidadController::class, 'like'])->name('comunidad.like');
    Route::post('/comunidad/publicacion/{id}/comentar', [ComunidadController::class, 'comentar'])->name('comunidad.comentar');
    Route::post('/comunidad/seguir/{id}', [ComunidadController::class, 'seguir'])->name('comunidad.seguir');
    Route::get('/usuario/{id}/seguidores', [ComunidadController::class, 'seguidores'])->name('usuario.seguidores');
    Route::get('/usuario/{id}/seguidos', [ComunidadController::class, 'seguidos'])->name('usuario.seguidos');
    Route::delete('/comentario/{id}/eliminar', [ComunidadController::class, 'eliminarComentario'])->name('comentario.eliminar');
    Route::get('/comentario/{comentario}/editar', [ComunidadController::class, 'edit'])->name('comentario.editar');
    Route::put('/comentario/{comentario}', [ComunidadController::class, 'update'])->name('comentario.update');
    Route::delete('/publicacion/{id}/eliminar', [ComunidadController::class, 'eliminarPublicacion'])->name('publicacion.eliminar');
    Route::delete('/like/{id}/eliminar', [ComunidadController::class, 'eliminarLike'])->name('like.eliminar');
    Route::delete('/seguidor/{id}/eliminar', [ComunidadController::class, 'eliminarSeguidor'])->name('seguidor.eliminar');
    Route::delete('/seguidos/{id}/eliminar', [ComunidadController::class, 'eliminarSeguido'])->name('seguidos.eliminar');
    Route::post('/publicacion/añadir', [ComunidadController::class, 'añadirPublicacion'])->name('publicacion.añadir');
    Route::get('/comunidad/usuarios', [ComunidadController::class, 'listadoUsuarios'])
    ->name('comunidad.usuarios');
    Route::get('/comunidad/usuarios/{id}', [ComunidadController::class, 'showUsuario'])->name('comunidad.showUsuario');
    Route::post('/comunidad/enviarSolicitud/{id}', [ComunidadController::class, 'enviarSolicitud'])->name('comunidad.enviarSolicitud');
    Route::get('/comunidad/solicitudes', [ComunidadController::class, 'verSolicitudes'])->name('comunidad.solicitudes');
    Route::post('/comunidad/aceptarSolicitud/{id}', [ComunidadController::class, 'aceptarSolicitud'])->name('comunidad.aceptarSolicitud');
    Route::post('/comunidad/rechazarSolicitud/{id}', [ComunidadController::class, 'rechazarSolicitud'])->name('comunidad.rechazarSolicitud');
    Route::get('/comunidad/amigos', [ComunidadController::class, 'amigos'])->name('comunidadAmigos');
    Route::get('/mensaje/{id}', [ComunidadController::class, 'chat'])->name('mensajesChat');
    Route::post('/mensaje/{id}', [ComunidadController::class, 'enviarMensaje'])->name('mensajesEnviar');
    Route::get('/publicacion/{id}/editar', [ComunidadController::class, 'editarPublicacion'])->name('publicacion.editar');
    Route::put('/publicacion/{id}/actualizar', [ComunidadController::class, 'actualizarPublicacion'])->name('publicacion.actualizar');
    });

Route::middleware('auth')->group(function(){
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfilIndex');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfilUpdate');
    //mostrar el panel de administrar del admin
    Route::get('/admin', [PerfilController::class, 'admin'])->name('admin');
    //mostrar el panel de configurar cuenta
    Route::get('/configuracion', [PerfilController::class, 'configuracion'])->name('configuracion');
}); 
