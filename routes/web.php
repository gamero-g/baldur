<?php

use App\Http\Controllers\BlogsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\VerificarPagoSignature;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']) 
    ->name('home');

Route::get('/admin', [\App\Http\Controllers\HomeController::class, 'adminHome']) 
    ->name('homeAdmin')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

// AUTH USERS

// ...Login
Route::get('/ingresar', [\App\Http\Controllers\AuthController::class, 'show'] )
     ->name('auth.login.show');

Route::post('/ingresar', [\App\Http\Controllers\AuthController::class, 'process'] )
    ->name('auth.login.process');

Route::post('/cerrar-sesion', [\App\Http\Controllers\AuthController::class, 'logout'] )
    ->name('auth.logout');


// ...Register

Route::get('/registrarse', [\App\Http\Controllers\AuthController::class, 'showRegister'] )
    ->name('auth.register');

Route::post('/registrarse', [\App\Http\Controllers\AuthController::class, 'processRegister'] )
    ->name('auth.register.process');

// BLOGS
Route::get('/blog', [\App\Http\Controllers\BlogsController::class, 'blog']) 
    ->name('blogs.blog');

Route::get('/blog/{id}', [\App\Http\Controllers\BlogsController::class, 'blogById']) 
    ->name('blogs.details');

Route::get('/productos', [\App\Http\Controllers\GamesController::class, 'allGames'])
    ->name('games.all');


Route::get('/{id}', [\App\Http\Controllers\GamesController::class, 'gameById'])
    ->name('games.details')
    ->whereNumber('id');

// ABM Productos

Route::get('/admin/adminJuegos', [\App\Http\Controllers\GamesController::class, 'adminJuegos'])
    ->name('adminJuegos')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::get('/admin/adminJuegos/crear', [\App\Http\Controllers\GamesController::class, 'create'])
    ->name('games.create')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::post('/admin/adminJuegos/crear', [\App\Http\Controllers\GamesController::class, 'store'])  
    ->name('games.store')
    ->middleware('auth');

Route::get('/admin/adminJuegos/{id}/eliminar', [\App\Http\Controllers\GamesController::class, 'delete']) 
    ->name('games.delete')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::post('/admin/adminJuegos/{id}/eliminar', [\App\Http\Controllers\GamesController::class, 'destroy']) 
    ->name('games.destroy')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::get('/admin/adminJuegos/{id}/editar', [\App\Http\Controllers\GamesController::class, 'edit'])
    ->name('games.edit')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::post('/admin/adminJuegos/{id}/editar', [\App\Http\Controllers\GamesController::class, 'update'])
    ->name('games.update')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);


// ADMIN BLOGS

Route::get('/admin/admingBlogs', [\App\Http\Controllers\BlogsController::class, 'adminBlogs'])
    ->name('blogs.adminBlogs')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);
    
Route::get('/admin/admingBlogs/contenido/{id}', [\App\Http\Controllers\BlogsController::class, 'showContent'])
    ->name('blogs.blogContenido')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::get('/admin/adminBlogs/crear', [\App\Http\Controllers\BlogsController::class, 'create'])
    ->name('blogs.create')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::post('/admin/adminBlogs/crear', [\App\Http\Controllers\BlogsController::class, 'store'])  
    ->name('blogs.store')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::get('/admin/adminBlogs/{id}/eliminar', [\App\Http\Controllers\BlogsController::class, 'delete']) 
    ->name('blogs.delete')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::post('/admin/adminBlogs/{id}/eliminar', [\App\Http\Controllers\BlogsController::class, 'destroy']) 
    ->name('blogs.destroy')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

    
Route::get('/admin/adminBlogs/{id}/editar', [\App\Http\Controllers\BlogsController::class, 'edit']) 
    ->name('blogs.edit')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::post('/admin/adminBlogs/{id}/editar', [\App\Http\Controllers\BlogsController::class, 'update']) 
    ->name('blogs.update')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);


// USER ADMIN

Route::get('/admin/adminUsuarios', [\App\Http\Controllers\UserController::class, 'adminUsers'])
    ->name('users.adminUsuarios')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::get('/admin/adminUsuarios/{id}/compras',[\App\Http\Controllers\UserController::class, 'compras'])
    ->name('users.compras')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::get('/admin/adminUsuarios/{id}/editar',[\App\Http\Controllers\UserController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);

Route::post('/admin/adminUsuarios/{id}/editar',[\App\Http\Controllers\UserController::class, 'update'])
    ->name('users.update')
    ->middleware('auth')
    ->middleware(CheckUserRole::class);


// PERFIL USUARIO

Route::get('/perfil', [\App\Http\Controllers\UserController::class, 'perfil'])
    ->name('users.perfil')
    ->middleware('auth');

Route::get('/perfil/editar-nombre', [\App\Http\Controllers\UserController::class, 'editName'])
    ->name('users.editName')
    ->middleware('auth');

Route::post('/perfil/editar-nombre', [\App\Http\Controllers\UserController::class, 'updateName'])
    ->name('users.updateName')
    ->middleware('auth');

Route::get('/perfil/editar-avatar', [\App\Http\Controllers\UserController::class, 'editAvatar'])
    ->name('users.editAvatar')
    ->middleware('auth');

Route::post('/perfil/editar-avatar', [\App\Http\Controllers\UserController::class, 'updateAvatar'])
    ->name('users.updateAvatar')
    ->middleware('auth');

Route::get('/perfil/editar-informacion', [\App\Http\Controllers\UserController::class, 'editInformacion'])
    ->name('users.editInformacion')
    ->middleware('auth');

Route::post('/perfil/editar-informacion', [\App\Http\Controllers\UserController::class, 'updateInformacion'])
    ->name('users.updateInformacion')
    ->middleware('auth');


// MERCADO PAGO

Route::get('/carrito', [\App\Http\Controllers\MecadoPagoController::class, 'carrito'])
    ->name('compras.carrito')
    ->middleware('auth');

Route::post('/carrito/{id}/agregar', [\App\Http\Controllers\MecadoPagoController::class, 'agregarAlCarrito'])
    ->name('compras.agregarAlCarrito')
    ->middleware('auth');

Route::post('/carrito/{id}/eliminar', [\App\Http\Controllers\MecadoPagoController::class, 'eliminarDelCarrito'])
    ->name('compras.eliminar')
    ->middleware('auth');

Route::post('/carrito/vaciar', [\App\Http\Controllers\MecadoPagoController::class, 'vaciarCarrito'])
    ->name('compras.vaciar')
    ->middleware('auth');

Route::get('/carrito/completar-compra', [\App\Http\Controllers\MecadoPagoController::class, 'checkout'])
    ->name('compras.checkout')
    ->middleware('auth');

Route::get('/carrito/completar-compra/success', [\App\Http\Controllers\MecadoPagoController::class, 'success'])
    ->name('compras.success');
    
Route::get('/carrito/completar-compra/failure', [\App\Http\Controllers\MecadoPagoController::class, 'failure'])
    ->name('compras.failure');
 
Route::post('/carrito/confirmar-compra', [\App\Http\Controllers\MecadoPagoController::class, 'verificarPagoMiddleware'])
    ->middleware(VerificarPagoSignature::class)
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->name('compras.verificar-pago');
