<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibroController extends Controller
{
    // Mostrar todos los libros (para todos los usuarios)
    public function index()
    {
        $libros = Libro::with('autor', 'categorias')->paginate(10);
        return view('libros.list', compact('libros'));
    }

    // Mostrar un libro específico
    public function show($id)
    {
        $libro = Libro::with('autor', 'categorias')->findOrFail($id);
        return view('libros.list', compact('libro'));
    }

    // Mostrar el formulario para crear un libro (solo usuarios registrados)
    public function create()
{
    if (!auth()->check()) {
        dd('No estás autenticado');
    }
    $autores = Autor::all();
    $categorias = Categoria::all();
    return view('libros.form', compact('autores', 'categorias'));
}

    // Almacenar un nuevo libro
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'autor_id' => 'required',
            'descripcion' => 'required',
            'categoria_id' => 'required|array',
        ]);

        $libro = new Libro();
        $libro->titulo = $request->titulo;
        $libro->autor_id = $request->autor_id;
        $libro->descripcion = $request->descripcion;
        $libro->save();

        $libro->categorias()->sync($request->categoria_id); // Relación muchos a muchos

        return redirect()->route('libros.index')->with('success', 'Libro creado exitosamente.');
    }

    // Mostrar formulario de edición (solo para el dueño o administrador)
    public function edit($id)
    {
        $libro = Libro::findOrFail($id);
        $autores = Autor::all();
        $categorias = Categoria::all();
        return view('libros.form', compact('libro', 'autores', 'categorias'));
    }

    // Actualizar un libro
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'autor_id' => 'required',
            'descripcion' => 'required',
            'categoria_id' => 'required|array',
        ]);

        $libro = Libro::findOrFail($id);
        $libro->titulo = $request->titulo;
        $libro->autor_id = $request->autor_id;
        $libro->descripcion = $request->descripcion;
        $libro->save();

        $libro->categorias()->sync($request->categoria_id); // Relación muchos a muchos

        return redirect()->route('libros.index')->with('success', 'Libro actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $libro = Libro::findOrFail($id);
        $libro->categorias()->detach();
        $libro->delete();

        return redirect()->route('libros.list')->with('success', 'Libro eliminado exitosamente.');
    }

    // Mostrar solo los libros del usuario autenticado
    public function misLibros()
    {
        $libros = auth()->user()->libros()->paginate(10);
        return view('libros.list', ['libros' => $libros]);
    }

    // Mostrar libros para administración (solo administradores)
    public function adminIndex()
    {
        $libros = Libro::with('autor', 'categorias')->paginate(10);
        return view('libros.list', ['libros' => $libros]);
    }
}
