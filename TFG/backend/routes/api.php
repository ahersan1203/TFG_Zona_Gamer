<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\NoticiaController;
use App\Models\Categoria;
use App\Models\User;

//Comunidad
Route::middleware('auth:sanctum')->group(function () {
    //Comunidad
    Route::get('/comunidad', [ComunidadController::class, 'apiIndex']);
   //Publicación
   Route::post('/publicacion', [ComunidadController::class, 'apiCrearPublicacion']);
    Route::get('/publicacion/{id}', [ComunidadController::class, 'apiShow']);
    Route::delete('/publicacion/{id}', [ComunidadController::class, 'apiEliminarPublicacion']);
    Route::put('/publicacion/{id}', [ComunidadController::class, 'apiActualizarPublicacion']);
    //Like
   Route::post('/publicacion/{id}/like', [ComunidadController::class, 'apiLike']);
    Route::delete('/like/{id}', [ComunidadController::class, 'apiEliminarLike']);
    //Comentarios
    Route::post('/publicacion/{id}/comentario', [ComunidadController::class, 'apiComentar']);
    Route::delete('/comentario/{id}', [ComunidadController::class, 'apiEliminarComentario']);
    Route::put('/comentario/{id}', [ComunidadController::class, 'apiActualizarComentario']);
    //Usuario
    Route::get('/usuarios', [ComunidadController::class, 'apiListadoUsuarios']);
    Route::get('/usuario/{id}', [ComunidadController::class, 'apiShowUsuario']);
    //Sistema Seguidos
    Route::get('/relaciones', [ComunidadController::class, 'apiRelaciones']);
    Route::post('/usuario/{id}/seguir', [ComunidadController::class, 'apiSeguir']);
    Route::delete('/seguidor/{id}', [ComunidadController::class, 'apiEliminarSeguidor']);
    Route::delete('/seguidos/{id}', [ComunidadController::class, 'apiEliminarSeguido']);
    //Peticiones
    Route::get('/solicitudes', [ComunidadController::class, 'apiSolicitudes']);
    Route::post('/solicitud/{id}/aceptar', [ComunidadController::class, 'apiAceptarSolicitud']);
    Route::post('/solicitud/{id}/rechazar', [ComunidadController::class, 'apiRechazarSolicitud']);
    //Amigos
    Route::get('/amigos', [ComunidadController::class, 'apiAmigos']);
    //Chat
    Route::get('/mensajes/{id}', [ComunidadController::class, 'apiChat']);
    Route::post('/mensajes/{id}', [ComunidadController::class, 'apiEnviarMensaje']);
    Route::get('/yo', function() {
        return auth()->user();
    });
});
//Perfil
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', [PerfilController::class, 'apiIndex']);
    Route::put('/perfil', [PerfilController::class, 'apiUpdate']);
    Route::get('/configuracion', [PerfilController::class, 'apiConfiguracion']);
});
//Auth
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::post('/forgot-password', [AuthController::class, 'apiForgotPassword']);
Route::post('/reset-password', [AuthController::class, 'apiResetPassword']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'apiLogout']);
});
//Admin
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'apiPanel']);
    Route::delete('/admin/publicacion/{id}', [AdminController::class, 'apiEliminarPublicacion']);
    Route::delete('/admin/comentario/{id}', [AdminController::class, 'apiEliminarComentario']);
    Route::delete('/admin/evento/{id}', [AdminController::class, 'apiEliminarEvento']);
    Route::delete('/admin/noticia/{id}', [AdminController::class, 'apiEliminarNoticia']);
    Route::delete('/admin/usuario/{id}', [AdminController::class, 'apiEliminarUsuario']);
    Route::get('/admin/usuario/{id}', [AdminController::class, 'apiShowUsuario']);
    Route::put('/usuarios/{id}', [AdminController::class, 'apiActualizarUsuario']);
});
//Evento
Route::get('/eventos', [EventoController::class, 'apiIndex']);
Route::get('/eventos/{id}', [EventoController::class, 'apiShow']);
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::post('/eventos', [EventoController::class, 'apiStore']);
    Route::put('/eventos/{evento}', [EventoController::class, 'apiUpdate']);
    Route::delete('/eventos/{evento}', [EventoController::class, 'apiDestroy']);
});
//Noticia
Route::get('/noticias', [NoticiaController::class, 'apiIndex']);
Route::get('/categorias', function () { return Categoria::all();});
Route::get('/noticias/{noticia}', [NoticiaController::class, 'apiShow']);
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::post('/noticias', [NoticiaController::class, 'apiStore']);
    Route::put('/noticias/{noticia}', [NoticiaController::class, 'apiUpdate']);
    Route::delete('/noticias/{noticia}', [NoticiaController::class, 'apiDestroy']);
});
