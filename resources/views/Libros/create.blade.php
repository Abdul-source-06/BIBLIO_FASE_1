@extends('layouts.app')

<form action="{{ route('libros.store') }}" method="POST">
    @csrf

    <!-- Título -->
    <div class="mb-4">
        <label for="titulo" class="block text-sm font-medium text-gray-700">Título:</label>
        <input 
            type="text" 
            id="titulo" 
            name="titulo" 
            required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        >
    </div>

    <!-- Nombre del autor -->
    <div class="mb-4">
        <label for="autor_nombre" class="block text-sm font-medium text-gray-700">Nombre del Autor:</label>
        <input 
            type="text" 
            id="autor_nombre" 
            name="autor_nombre" 
            required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        >
    </div>

    <!-- Apellido del autor -->
    <div class="mb-4">
        <label for="autor_apellido" class="block text-sm font-medium text-gray-700">Apellido del Autor:</label>
        <input 
            type="text" 
            id="autor_apellido" 
            name="autor_apellido" 
            required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        >
    </div>

    <!-- Categorías (Seleccionar o Crear) -->
    <div class="mb-4">
        <label for="categorias" class="block text-sm font-medium text-gray-700">Categorías:</label>

        <!-- Campo de selección de categorías existentes -->
        <select 
            name="categorias[]" 
            id="categorias" 
            multiple 
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            {{ $categorias->isEmpty() ? '' : 'required' }}
        >
            @if ($categorias->isEmpty())
                <option value="" disabled>No hay categorías disponibles</option>
            @else
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            @endif
        </select>

        <!-- Campo de texto para agregar nueva categoría -->
        @if ($categorias->isEmpty())
            <div class="mt-2">
                <input 
                    type="text" 
                    id="newCategory" 
                    name="new_category" 
                    placeholder="Escribe una nueva categoría"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>
        @endif
    </div>

    <!-- Descripción -->
    <div class="mb-4">
        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</label>
        <textarea 
            id="descripcion" 
            name="descripcion" 
            required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            rows="4"
        ></textarea>
    </div>

    <!-- Botón de Enviar -->
    <div class="flex justify-end">
        <button 
            type="submit"
            class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
            Crear Libro
        </button>
    </div>
</form>
