@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold mb-6">Crear Nueva Categoría</h1>

    @role('administrador')
    <form action="{{ route('categorias.store') }}" method="POST" class="mb-8">
        @csrf
        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Categoría:</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                required 
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Escribe el nombre de la categoría"
            >
        </div>

        <button type="submit" class="inline-block px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 ease-in-out">
            Crear Categoría
        </button>
    </form>
    @endrole

    <div>
        <h2 class="text-2xl font-semibold mb-4">Categorías Existentes</h2>

        @if($categorias->count())
            <ul class="space-y-2">
                @foreach($categorias as $categoria)
                    <li class="flex items-center justify-between bg-gray-100 p-3 rounded-md shadow-sm">
                        <span class="text-gray-800">{{ $categoria->nombre }}</span>

                        @role('administrador')
                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta categoría?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                Eliminar
                            </button>
                        </form>
                        @endrole
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">No hay categorías aún.</p>
        @endif
    </div>
</div>
@endsection
