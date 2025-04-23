<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Rutas públicas (accesibles para usuarios invitados)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
Route::get('/libros/{libro}', [LibroController::class, 'show'])->name('libros.show');
Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
Route::get('/autores/{autor}', [AutorController::class, 'show'])->name('autores.show');
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');

// Rutas para dashboard y perfil (usuarios autenticados)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para usuarios registrados
Route::middleware('auth')->group(function () {
    // Solo permitir a usuarios registrados crear sus propios libros
    Route::get('/libros/create', [LibroController::class, 'create'])->name('libros.create');
    Route::post('/libros', [LibroController::class, 'store'])->name('libros.store');
    
    // Ver, editar y eliminar solo sus propios libros
    Route::get('/mis-libros', [LibroController::class, 'misLibros'])->name('libros.mis-libros');
    Route::get('/mis-libros/{libro}/edit', [LibroController::class, 'edit'])->name('libros.edit');
    Route::put('/mis-libros/{libro}', [LibroController::class, 'update'])->name('libros.update');
    Route::delete('/mis-libros/{libro}', [LibroController::class, 'destroy'])->name('libros.destroy');
});

// Rutas exclusivas para administradores
Route::middleware(['auth', 'role:administrador'])->group(function () {
    // CRUD completo para autores y categorías
    Route::resource('autores', AutorController::class)->except(['index', 'show']);
    Route::resource('categorias', CategoriaController::class)->except(['index', 'show']);
    
    // Administración de usuarios
    Route::resource('users', UserController::class);
    
    // Administración de todos los libros (incluso los de otros usuarios)
    Route::get('/admin/libros', [LibroController::class, 'adminIndex'])->name('admin.libros.index');
    Route::get('/admin/libros/{libro}/edit', [LibroController::class, 'adminEdit'])->name('admin.libros.edit');
    Route::put('/admin/libros/{libro}', [LibroController::class, 'adminUpdate'])->name('admin.libros.update');
    Route::delete('/admin/libros/{libro}', [LibroController::class, 'adminDestroy'])->name('admin.libros.destroy');
});

require __DIR__.'/auth.php';