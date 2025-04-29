@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-6">Lista de Libros</h1>

        <a href="{{ route('libros.create') }}" class="inline-block px-4 py-2 mb-4 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Crear un nuevo libro</a>

        <table class="min-w-full table-auto bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Título</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Autor</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Categorías</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $libro->titulo }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $libro->autor->nombre }} {{ $libro->autor->apellido }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            @foreach($libro->categorias as $categoria)
                                <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs mr-2">{{ $categoria->nombre }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <a href="{{ route('libros.edit', $libro->id) }}" class="text-blue-600 hover:text-blue-800">Editar</a>

                            <form action="{{ route('libros.destroy', $libro->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 ml-4">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
