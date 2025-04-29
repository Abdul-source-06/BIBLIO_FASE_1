@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-6">Lista de Libros</h1>

        <a href="{{ route('libros.create') }}" class="inline-block px-6 py-3 mb-6 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out shadow-md">Crear un nuevo libro</a>

        <table class="min-w-full table-auto bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Título</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Autor</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Categorías</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $libro->titulo }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $libro->autor->nombre }} {{ $libro->autor->apellido }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            @foreach($libro->categorias as $categoria)
                                <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs mr-2">{{ $categoria->nombre }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ Str::limit($libro->descripcion, 50) }}</td>

                        <td class="px-6 py-4 text-sm text-gray-800 flex space-x-4">
    @if(auth()->user()->hasRole('administrador') || auth()->id() === $libro->user_id)
        <a href="{{ route('libros.edit', $libro->id) }}" 
           class="inline-block bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-300 ease-in-out">
            Editar
        </a>

        <form action="{{ route('libros.destroy', $libro->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="inline-block bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-300 ease-in-out">
                Eliminar
            </button>
        </form>
    @endif
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
