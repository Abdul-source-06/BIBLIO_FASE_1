<form action="{{ isset($libro) ? route('libros.update', $libro) : route('libros.store') }}" method="POST">
    @csrf
    @if (isset($libro))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $libro->titulo ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="autor_id" class="form-label">Autor</label>
        <select name="autor_id" id="autor_id" class="form-select">
            <option value="">Seleccionar Autor</option>
            @foreach($autores as $autor)
                <option value="{{ $autor->id }}" @selected(old('autor_id', $libro->autor_id ?? '') == $autor->id)>
                    {{ $autor->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $libro->descripcion ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categorías</label>
        <select name="categoria_id[]" id="categoria_id" class="form-select" multiple>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                    @selected(in_array($categoria->id, old('categoria_id', $libro->categorias->pluck('id')->toArray() ?? [])))>
                    {{ $categoria->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($libro) ? 'Actualizar' : 'Crear' }}</button>
</form>
