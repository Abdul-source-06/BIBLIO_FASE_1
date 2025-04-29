@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <h2 class="text-2xl font-bold mb-6">Editar Libro</h2>

    <form action="{{ route('libros.update', $libro->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="mb-4">
            <label for="titulo" class="block text-sm font-medium text-gray-700">Título:</label>
            <input 
                type="text" 
                id="titulo" 
                name="titulo" 
                value="{{ $libro->titulo }}" 
                required 
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>

        <!-- Autor -->
        <div class="mb-4">
            <label for="autor_id" class="block text-sm font-medium text-gray-700">Autor:</label>
            <select 
                name="autor_id" 
                id="autor_id" 
                required 
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
                <option value="">— Seleccionar autor —</option>
                @foreach($autores as $autor)
                    <option value="{{ $autor->id }}" {{ $libro->autor_id == $autor->id ? 'selected' : '' }}>
                        {{ $autor->nombre }} {{ $autor->apellido }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Categorías -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Categorías:</label>

            <div id="categoria-container" class="space-y-2">
                @foreach ($libro->categorias as $categoria)
                    <select 
                        name="categorias[]" 
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="">— Seleccionar categoría —</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ $categoria->id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                @endforeach

                {{-- Para añadir más categorías --}}
                <select 
                    name="categorias[]" 
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">— Seleccionar categoría —</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <button 
                type="button" 
                onclick="addCategoria()" 
                class="mt-2 px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition"
            >
                + Añadir Categoría
            </button>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</label>
            <textarea 
                id="descripcion" 
                name="descripcion" 
                required 
                rows="4"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >{{ $libro->descripcion }}</textarea>
        </div>

        <div class="flex justify-end">
            <button 
                type="submit" 
                class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                Actualizar Libro
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function addCategoria() {
        const select = document.createElement('select');
        select.name = 'categorias[]';
        select.className = "mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500";
        
        const optionDefault = document.createElement('option');
        optionDefault.text = '— Seleccionar categoría —';
        optionDefault.value = '';
        select.appendChild(optionDefault);

        @foreach ($categorias as $cat)
            const option = document.createElement('option');
            option.value = '{{ $cat->id }}';
            option.text = '{{ $cat->nombre }}';
            select.appendChild(option);
        @endforeach

        document.getElementById('categoria-container').appendChild(select);
    }
</script>
@endpush
