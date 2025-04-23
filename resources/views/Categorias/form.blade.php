@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($categoria) ? 'Editar Categoría' : 'Crear Categoría' }}</h2>

    <form action="{{ isset($categoria) ? route('categorias.update', $categoria) : route('categorias.store') }}" method="POST">
        @csrf
        @if (isset($categoria))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $categoria->name ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($categoria) ? 'Actualizar' : 'Crear' }}</button>
    </form>
</div>
@endsection
