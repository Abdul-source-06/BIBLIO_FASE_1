<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    // Mostrar lista de autores
    public function index()
    {
        $autores = Autor::all();
        return view('autores.index', compact('autores'));
    }

    // Mostrar un autor específico
    public function show($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autores.show', compact('autor'));
    }

    // Crear un nuevo autor (solo administradores)
    public function create()
    {
        return view('autores.create');
    }

    // Almacenar un nuevo autor
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
        ]);

        Autor::create($request->all());

        return redirect()->route('autores.index')->with('success', 'Autor creado exitosamente.');
    }

    // Editar un autor (solo administradores)
    public function edit($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autores.edit', compact('autor'));
    }

    // Actualizar un autor
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
        ]);

        $autor = Autor::findOrFail($id);
        $autor->update($request->all());

        return redirect()->route('autores.index')->with('success', 'Autor actualizado exitosamente.');
    }

    // Eliminar un autor (solo administradores)
    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);
        $autor->delete();

        return redirect()->route('autores.index')->with('success', 'Autor eliminado exitosamente.');
    }
}
