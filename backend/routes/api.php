<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\discoController;
use App\Http\Controllers\reviewController;
use App\Http\Controllers\userController;
use App\Http\Controllers\BeRealController;
use App\Http\Controllers\comentariosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\categoriasReviewController;
use App\Http\Controllers\friendController;
use App\Http\Controllers\seguidoresController;
use App\Http\Controllers\CiudadController;


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
// RUTAS DE USUARIO
Route::get('/csrf-token', function () {
    return csrf_token();
});
Route::post('auth', [AuthController::class, 'auth']);
// middleware usuarios
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// ruta para hacer login
Route::post('login', [userController::class, 'login']);
// ruta para hacer logout
Route::post('register', [userController::class, 'store']);
Route::get('/users', [userController::class, 'getUsers']);
//ruta para obtener un usuario por id
Route::get('/users/{id}', [userController::class, 'getUserById']);
// ruta para crear un usuario
Route::post('/users', [userController::class, 'create']);
// ruta para borrar un usuario
Route::delete('/users/{id}', [userController::class, 'delete']);
// ruta para editar un usuario
Route::put('/users/{id}', [userController::class, 'update']);
//ruta de qr
Route::get('/generate-qr-code/{user}', [UserController::class, 'generateQRCode']);
//ruta para acceder a la profile_photo de un usuario
Route::get('/users/profile_photo/{id}', [userController::class, 'getProfilePhoto']);
Route::get('users/seguidores/{id}', [userController::class, 'getFollowers']);
//ruta para obtener todos los usuarios
Route::get('/users', [userController::class, 'index']);
//ruta para update crud
Route::put('/update/users/{id}', [userController::class, 'updateCrud']);




// RUTAS DE DISCOTECAS
// ruta para obtener todas las discotecas
Route::get('/discotecas', [discoController::class, 'getDiscotecas']);
// ruta para obtener una discoteca por id
Route::get('/discotecas/{id}', [discoController::class, 'getDiscoteca']);
// ruta para crear una discoteca
Route::post('/discotecas', [discoController::class, 'createDiscoteca']);
// ruta para actualizar una discoteca
Route::put('/discotecas/{id}', [discoController::class, 'updateDiscoteca']);
// ruta para borrar una discoteca
Route::delete('/discotecas/{id}', [discoController::class, 'delete']);
// ruta para obtener las discotecas por nombre
Route::get('/discotecas/nombre/{nombre_local}', [discoController::class, 'getDiscotecasByName']);
// ruta para obtener las discotecas por edad
Route::get('/discotecas/edad/{minEdad}', [discoController::class, 'getDiscotecasByAge']);
// ruta para obtener las discotecas por horario
Route::get('/discotecas/horario/{horario}', [discoController::class, 'getDiscotecasBySchedule']);


// RUTAS DE REVIEWS
// ruta para crear una review
Route::post('/reviews', [reviewController::class, 'createReview']);
// ruta para obtener todas las reviews
Route::get('/reviews', [reviewController::class, 'getReviews']);
// ruta para obtener una review por id
Route::get('/review/{id}', [reviewController::class, 'getReview']);
// ruta para actualizar una review
Route::put('/reviews/{id}', [reviewController::class, 'update']);
// ruta para borrar una review
Route::delete('/reviews/{id}', [reviewController::class, 'delete']);
// ruta para obtener las reviews por id de usuario
Route::get('/reviews/user/{id}', [reviewController::class, 'getReviewsByUser']);
// ruta para obtener las reviews por id de discoteca
Route::get('/reviews/disco/{id}', [reviewController::class, 'getReviewsByDisco']);
// ruta para obtener las reviews por puntuacion
Route::get('/reviews/puntuacion/{puntuacion}', [reviewController::class, 'getReviewsByPuntuacion']);
// RUTAS DE CATEGORIAS_REVIEWS
// ruta para obtener todas las categorias
Route::get('/categorias_reviews', [categoriasReviewController::class, 'getCategorias']);
// ruta para obtener una categoria por nombre
Route::get('/categorias_reviews/{nombre}', [categoriasReviewController::class, 'getCategoria']);




// RUTAS DE SEGUIDORES
// ruta para obtener todos los seguidores de un usuario
Route::get('/seguidores/{id}', [seguidoresController::class, 'getSeguidores']);
//ruta para obtener todos los amigos de un usuario
Route::get('/amigos/{id}', [seguidoresController::class, 'getAmigos']);
// ruta para añadir un seguidor
Route::post('/seguidores', [seguidoresController::class, 'addSeguidor']);
// ruta para comprobar si un usuario sigue a otro usuario
Route::get('/seguidores/{seguidor_id}/{seguido_id}', [seguidoresController::class, 'checkIfSeguidor']);

// RUTAS DE SEGUIDORES
// ruta para obtener todos los seguidores de un usuario
Route::get('/seguidores/{id}', [seguidoresController::class, 'getSeguidores']);
//ruta para obtener todos los amigos de un usuario
Route::get('/amigos/{id}', [seguidoresController::class, 'getAmigos']);
// ruta para añadir un seguidor
Route::post('/seguidores', [seguidoresController::class, 'addSeguidor']);
// ruta para comprobar si un usuario sigue a otro usuario
Route::get('/seguidores/{seguidor_id}/{seguido_id}', [seguidoresController::class, 'checkIfSeguidor']);
//ruta para crear 




// rutas bereal
Route::post('/inTime', [BeRealController::class, 'createBereal']);
//ruta para obtener y mostrar
Route::get('/inTime/{id}', [BeRealController::class, 'show']);
//mostrar todos
Route::get('/inTimes', [BeRealController::class, 'index']);
//crear comentari 
Route::post('/inTime/{id}/commentari', [BeRealController::class, 'addComentari']);
//veure comentari
Route::post('/inTime/{id}/commentaris', [BeRealController::class, 'getComentaris']);
// crear bereal
// eliminar bereal
Route::delete('/inTime/{id}', [BeRealController::class, 'delete']);
// editar bereal
Route::put('/inTime/{id}', [BeRealController::class, 'update']);

//RUTAS PARA COMENTARIOS BEREAL
//mostrar tots els comentaris apartir de la id de bereal
Route::get('/comentarios/{id_bereal}', [comentariosController::class, 'index']);
//crea un nou comentari
Route::post('/comentarios', [comentariosController::class, 'store']);
//mostra un comentari especific
Route::get('/comentarios/show/{id}', [comentariosController::class, 'show']);
//eliminar comentari
Route::delete('/comentarios/{id}', [comentariosController::class, 'destroy']);
// mostrar tots els comentaris
Route::get('/comentarios', [comentariosController::class, 'indexComentarios']);
// editar un comentario
Route::put('/comentarios/{id}', [comentariosController::class, 'update']);




//ciudades
Route::get('/ciudades', [CiudadController::class, 'index']);