@extends('layouts.app')

@section('content')
    <h1>Editar Libro</h1>

    <form action="{{ route('libros.update', $libro->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="{{ $libro->titulo }}" required>
        </div>

        <div>
            <label for="autor">Autor:</label>
            <select name="autor_id" id="autor" required>
                @foreach ($autores as $autor)
                    <option value="{{ $autor->id }}" {{ $libro->autor_id == $autor->id ? 'selected' : '' }}>
                        {{ $autor->nombre }} {{ $autor->apellido }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="categorias">Categorías:</label>
            <select name="categorias[]" id="categorias" multiple required>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" 
                        {{ $libro->categorias->contains($categoria->id) ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required>{{ $libro->descripcion }}</textarea>
        </div>

        <button type="submit">Actualizar Libro</button>
    </form>
@endsection
