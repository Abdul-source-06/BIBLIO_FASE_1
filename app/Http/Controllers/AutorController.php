<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    // Mostrar todos los autores
    public function index()
    {
        $autores = Autor::withCount('libros')->paginate(10);
        return view('autores.list', compact('autores'));
    }

    // Mostrar un autor específico
    public function show($id)
    {
        $autor = Autor::with('libros')->findOrFail($id);
        $autores = collect([$autor]); // Convertir a colección para usar la misma vista list
        return view('autores.list', compact('autores', 'autor'));
    }

    // Mostrar formulario para crear un autor (solo admin)
    public function create()
    {
        return view('autores.form');
    }

    // Almacenar un nuevo autor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
        ]);

        $autor = Autor::create($request->all());

        return redirect()->route('autores.index')->with('success', 'Autor creado exitosamente.');
    }

    // Mostrar formulario para editar un autor
    public function edit($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autores.form', compact('autor'));
    }

    // Actualizar un autor
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'biografia' => 'nullable',
        ]);

        $autor = Autor::findOrFail($id);
        $autor->update($request->all());

        return redirect()->route('autores.index')->with('success', 'Autor actualizado exitosamente.');
    }

    // Eliminar un autor
    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);
        
        // Verificar si tiene libros asociados
        if ($autor->libros()->count() > 0) {
            return redirect()->route('autores.index')->with('error', 'No se puede eliminar un autor con libros asociados.');
        }
        
        $autor->delete();
        return redirect()->route('autores.index')->with('success', 'Autor eliminado exitosamente.');
    }
}