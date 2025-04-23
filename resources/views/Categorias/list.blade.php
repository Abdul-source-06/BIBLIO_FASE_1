@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Categorías</h2>

    @foreach($categorias as $categoria)
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">{{ $categoria->name }}</h5>
                <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-info">Ver Detalles</a>
                @if(auth()->user() && auth()->user()->can('update', $categoria))
                    <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">Editar</a>
                @endif
                @if(auth()->user() && auth()->user()->can('delete', $categoria))
                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    <div class="mt-3">
        {{ $categorias->links() }}
    </div>
</div>
@endsection
