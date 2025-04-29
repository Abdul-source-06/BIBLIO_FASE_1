@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($autor) ? 'Editar Autor' : 'Crear Autor' }}</h2>

    <form action="{{ isset($autor) ? route('autores.update', $autor) : route('autores.store') }}" method="POST">
        @csrf
        @if (isset($autor))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $autor->name ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname', $autor->surname ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($autor) ? 'Actualizar' : 'Crear' }}</button>
    </form>
</div>
@endsection
