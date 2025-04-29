@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold mb-6">Crear Nuevo Libro</h1>

    <form action="{{ route('libros.store') }}" method="POST">
      @csrf

      <!-- Título -->
      <div class="mb-4">
        <label for="titulo" class="block text-sm font-medium text-gray-700">Título:</label>
        <input 
          type="text" id="titulo" name="titulo" required
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        >
      </div>

      <!-- Autor -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700">Autor:</label>
        <select 
          name="autor_id" id="autor_id" required
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        >
          <option value="">— Seleccionar autor —</option>
          @foreach($autores as $autor)
            <option value="{{ $autor->id }}">{{ $autor->nombre }} {{ $autor->apellido }}</option>
          @endforeach
        </select>
        <p class="my-2 text-center text-gray-500">— o —</p>
        <a href="{{ route('autores.create') }}" class="inline-block px-5 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 ease-in-out">
          Crear nuevo autor
        </a>
      </div>

      <!-- Categorías -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Categorías:</label>

        <div id="categorias-container">
          <div class="categoria-select mb-2 flex gap-2 items-center">
            <select name="categorias[]" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">— Seleccionar Categoría —</option>
              @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <button type="button" id="add-categoria-btn" class="mt-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition duration-200">
          + Añadir categoría
        </button>

        <p class="my-2 text-center text-gray-500">— o —</p>
        <a 
          href="{{ route('categorias.create') }}" 
          class="inline-block px-5 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 ease-in-out"
        >
          Crear Nueva Categoría
        </a>
      </div>

      <!-- Descripción -->
      <div class="mb-6">
        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</label>
        <textarea 
          id="descripcion" name="descripcion" required rows="4"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
      </div>

      <div class="flex justify-end">
        <button 
          type="submit"
          class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out"
        >
          Crear Libro
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('categorias-container');
    const addBtn = document.getElementById('add-categoria-btn');

    addBtn.addEventListener('click', () => {
      const original = container.querySelector('.categoria-select');
      const clone = original.cloneNode(true);

      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.textContent = '✖';
      removeBtn.className = 'ml-2 px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700';
      removeBtn.onclick = () => clone.remove();

      clone.appendChild(removeBtn);
      container.appendChild(clone);
    });
  });
</script>
@endpush
