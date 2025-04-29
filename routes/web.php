<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AutorController;

// Página principal
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Perfil del usuario
Route::middleware(['auth'])->group(function () {
    Route::controller(ProfileController::class)
        ->prefix('profile')->name('profile.')
        ->group(function () {
            Route::get('/', 'edit')->name('edit');  
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });

    // Redirección al index de libros al entrar al dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('libros.index');
    })->name('dashboard');
});

// Rutas para administradores (todas las operaciones CRUD)
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::resource('libros', LibroController::class)->except(['index', 'show']);

    Route::get('autores/create', [AutorController::class, 'create'])->name('autores.create');
    Route::post('autores', [AutorController::class, 'store'])->name('autores.store');
    Route::delete('autores/{autor}', [AutorController::class, 'destroy'])->name('autores.destroy');

    Route::get('categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::delete('categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
});

// Rutas accesibles por cualquier usuario autenticado (usuarios y admin)
Route::middleware(['auth'])->group(function () {
    Route::get('libros', [LibroController::class, 'index'])->name('libros.index');
    Route::get('libros/{libro}/edit', [LibroController::class, 'edit'])->name('libros.edit');
    Route::put('libros/{libro}', [LibroController::class, 'update'])->name('libros.update');
    Route::delete('libros/{libro}', [LibroController::class, 'destroy'])->name('libros.destroy');
    Route::post('libros', [LibroController::class, 'store'])->name('libros.store');
    Route::get('libros/create', [LibroController::class, 'create'])->name('libros.create');
});

require __DIR__.'/auth.php';
