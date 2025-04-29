<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function create()
    {
        $categorias = Categoria::all();   
        return view('categorias.create', compact('categorias'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
        ]);


        Categoria::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('libros.create')->with('success', 'Categoría creada correctamente');
    }

    public function destroy($id)
{
    $categoria = Categoria::findOrFail($id);
    $categoria->delete();

    return redirect()->route('categorias.create')->with('success', 'Categoría eliminada correctamente.');
}
}
