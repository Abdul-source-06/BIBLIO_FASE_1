@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Libros</h2>

    @foreach($libros as $libro)
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">{{ $libro->title }}</h5>
                <p class="card-text">Autor: {{ $libro->author->name }}</p>
                <p class="card-text">Descripción: {{ $libro->description }}</p>
                <p class="card-text">Categorías: {{ $libro->categories->pluck('name')->join(', ') }}</p>
                <a href="{{ route('libros.show', $libro) }}" class="btn btn-info">Ver Detalles</a>
                @if(auth()->user() && auth()->user()->can('update', $libro))
                    <a href="{{ route('libros.edit', $libro) }}" class="btn btn-warning">Editar</a>
                @endif
                @if(auth()->user() && auth()->user()->can('delete', $libro))
                    <form action="{{ route('libros.destroy', $libro) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    <div class="mt-3">
        {{ $libros->links() }}
    </div>
</div>
@endsection
