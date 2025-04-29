<?php
namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Categoria;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    // Mostrar la lista de libros
    public function index()
    {
        $libros = Libro::with(['autor', 'categorias'])->get();
        return view('libros.index', compact('libros'));
    }

    // Mostrar el formulario para crear un libro
    public function create()
{
    // Obtener IDs de autores ya asignados a libros
    $autoresAsignados = Libro::pluck('autor_id')->toArray();

    // Excluir autores que ya están asignados a un libro
    $autores = Autor::whereNotIn('id', $autoresAsignados)->get();

    $categorias = Categoria::all();

    return view('libros.create', compact('autores', 'categorias'));
}

    // Guardar un nuevo libro
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor_id' => 'required|exists:autores,id',
            'categorias' => 'nullable|array',
            'new_category' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
        ]);
    
        try {
            $user_id = auth()->id();
    
            $libro = Libro::create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'autor_id' => $request->autor_id,
                'user_id' => $user_id,
            ]);
    
            $categoriaIds = [];
    
            if ($request->has('categorias')) {
                $categoriaIds = $request->categorias;
            }
    
            if ($request->filled('new_category')) {
                $nuevaCategoria = Categoria::firstOrCreate(['nombre' => $request->new_category]);
                $categoriaIds[] = $nuevaCategoria->id;
            }
    
            $libro->categorias()->sync($categoriaIds);
    
            return redirect()->route('libros.index')
                ->with('success', 'Libro creado correctamente');
    
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Mostrar el formulario para editar un libro
    public function edit(Libro $libro)
{

    $autoresAsignados = Libro::where('id', '!=', $libro->id)->pluck('autor_id')->toArray();


    $autores = Autor::whereNotIn('id', $autoresAsignados)->orWhere('id', $libro->autor_id)->get();

    $categorias = Categoria::all();

    return view('libros.edit', compact('libro', 'autores', 'categorias'));
}

    // Actualizar un libro existente
    public function update(Request $request, Libro $libro)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'autor_id' => 'required|exists:autores,id',
        'descripcion' => 'required|string',
        'categorias' => 'required|array',
        'categorias.*' => 'nullable|exists:categorias,id',
    ]);

    $libro->update([
        'titulo' => $request->titulo,
        'autor_id' => $request->autor_id,
        'descripcion' => $request->descripcion,
    ]);

    $libro->categorias()->sync(array_filter($request->categorias));

    return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente.');
}

    // Eliminar un libro
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index');
    }
}
