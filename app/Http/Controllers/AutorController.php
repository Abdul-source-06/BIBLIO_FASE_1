<?php
namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function create()
    {
        $autores = Autor::all();   
        return view('autores.create', compact('autores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
        ]);

        Autor::create($request->only('nombre', 'apellido'));
        return redirect()->route('libros.create')->with('success', 'Autor creado correctamente');
    }

    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);
        $autor->delete();

        return redirect()->route('autores.create')->with('success', 'Autor eliminado correctamente');
    }
}
