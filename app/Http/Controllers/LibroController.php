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
        $autores = Autor::all();
        $categorias = Categoria::all();
        return view('libros.create', compact('autores', 'categorias'));
    }

    // Guardar un nuevo libro
    public function store(Request $request)
{
    // Validar los datos
    $request->validate([
        'titulo' => 'required|string|max:255',
        'autor' => 'required|string|max:255',
        'categorias' => 'required|array',
        'descripcion' => 'required|string',
        'new_category' => 'nullable|string|max:255', // Para las nuevas categorías
    ]);

    // Obtener el ID del usuario autenticado
    $user_id = auth()->id(); // Esto obtiene el ID del usuario autenticado

    // Crear o obtener el autor
    $autor = Autor::firstOrCreate(
        ['nombre' => $request->autor]
    );

    // Crear o obtener las categorías seleccionadas
    $categorias = collect($request->categorias);

    // Si hay una nueva categoría, la creamos y la añadimos al array
    if ($request->new_category) {
        $nuevaCategoria = Categoria::create(['nombre' => $request->new_category]);
        $categorias->push($nuevaCategoria->id);
    }

    // Crear el libro
    $libro = Libro::create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'autor_id' => $autor->id,
        'user_id' => $user_id, // Asignamos el user_id al libro
    ]);

    // Asociar el libro con las categorías
    $libro->categorias()->sync($categorias);

    // Redirigir a la lista de libros
    return redirect()->route('libros.index');
}
    // Mostrar el formulario para editar un libro existente
    public function edit(Libro $libro)
    {
        $autores = Autor::all();
        $categorias = Categoria::all();
        return view('libros.edit', compact('libro', 'autores', 'categorias'));
    }

    // Actualizar un libro existente
    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'titulo' => 'required',
            'autor_id' => 'required',
            'descripcion' => 'required',
            'categorias' => 'required|array'
        ]);

        $libro->update($request->all());
        $libro->categorias()->sync($request->categorias);

        return redirect()->route('libros.index');
    }

    // Eliminar un libro
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index');
    }
}
