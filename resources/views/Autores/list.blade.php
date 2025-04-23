@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Autores</h2>

    @foreach($autores as $autor)
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">{{ $autor->name }} {{ $autor->surname }}</h5>
                <a href="{{ route('autores.show', $autor) }}" class="btn btn-info">Ver Detalles</a>
                @if(auth()->user() && auth()->user()->can('update', $autor))
                    <a href="{{ route('autores.edit', $autor) }}" class="btn btn-warning">Editar</a>
                @endif
                @if(auth()->user() && auth()->user()->can('delete', $autor))
                    <form action="{{ route('autores.destroy', $autor) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    <div class="mt-3">
        {{ $autores->links() }}
    </div>
</div>
@endsection
