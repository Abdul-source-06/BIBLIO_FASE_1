<?php

use App\Http\Controllers\LibroController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('libros.index');
    })->name('dashboard');

}); 
Route::controller(ProfileController::class)
     ->prefix('profile')->name('profile.')
     ->group(function () {
         Route::get('/', 'edit')->name('edit');  
         Route::patch('/', 'update')->name('update');
         Route::delete('/', 'destroy')->name('destroy');
     });

Route::middleware(['auth'])->group(function () {
    // Rutas para los Libros
    Route::get('libros', [LibroController::class, 'index'])->name('libros.index');
    Route::get('libros/create', [LibroController::class, 'create'])->name('libros.create');
    Route::post('libros', [LibroController::class, 'store'])->name('libros.store');
    Route::get('libros/{libro}/edit', [LibroController::class, 'edit'])->name('libros.edit');
    Route::put('libros/{libro}', [LibroController::class, 'update'])->name('libros.update');
    Route::delete('libros/{libro}', [LibroController::class, 'destroy'])->name('libros.destroy');
});

require __DIR__.'/auth.php';
