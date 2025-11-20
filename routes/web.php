<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotaController;
use Illuminate\Support\Facades\Auth; // Importar el Facade Auth


Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación (reemplazo de Auth::routes())
Auth::routes([
    'register' => true, // Habilita el registro de usuarios
    'reset'    => true, // Habilita la funcionalidad de reseteo de contraseña
    'verify'   => false, // Deshabilita la verificación de email (puedes cambiarlo a true si la usas)
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts', PostController::class);

// Comentarios
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Rutas para Notas
Route::resource('notas', NotaController::class)->only(['index', 'store']);

// Rutas anidadas para Actividades (CRUD)
Route::resource('notas.actividades', ActividadController::class)
    ->parameters(['actividades' => 'actividad']) // Estandariza el nombre del parámetro a 'actividad'
    ->shallow() // Hace que las rutas de edit, update, destroy no estén anidadas
    ->except(['index', 'show']); // Excluimos las que no usaremos
