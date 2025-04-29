@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold mb-6">Crear Nuevo Autor</h1>

    @role('administrador')
    <form action="{{ route('autores.store') }}" method="POST" class="mb-8">
        @csrf
        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Autor:</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                required 
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Escribe el nombre del autor"
            >
        </div>

        <div class="mb-4">
            <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido del Autor:</label>
            <input 
                type="text" 
                id="apellido" 
                name="apellido" 
                required 
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Escribe el apellido del autor"
            >
        </div>

        <button type="submit" class="inline-block px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 ease-in-out">
            Crear Autor
        </button>
    </form>
    @endrole

    <div>
        <h2 class="text-2xl font-semibold mb-4">Autores Existentes</h2>

        @if($autores->count())
            <ul class="space-y-2">
                @foreach($autores as $autor)
                    <li class="flex items-center justify-between bg-gray-100 p-3 rounded-md shadow-sm">
                        <span class="text-gray-800">{{ $autor->nombre }} {{ $autor->apellido }}</span>

                        @role('administrador')
                        <form action="{{ route('autores.destroy', $autor->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este autor?');">
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
            <p class="text-gray-600">No hay autores aún.</p>
        @endif
    </div>
</div>
@endsection
