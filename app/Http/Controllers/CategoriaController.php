<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    // Mostrar lista de categorías
    public function index()
    {
        $categorias = Categoria::paginate(10);
        return view('categorias.list', compact('categorias')); 
    }

    // Mostrar una categoría específica
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.list', compact('categoria')); 
    }

    public function create(): View
    {
        return view('categorias.form');
    }

    // Almacenar una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    // Editar una categoría (solo administradores)
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.form', compact('categoria'));
    }

    // Actualizar una categoría
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    // Eliminar una categoría (solo administradores)
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
