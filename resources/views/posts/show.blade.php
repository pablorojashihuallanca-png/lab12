@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p><small>Por: {{ $post->user->name }}</small></p>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Volver</a>

    <hr>
    <h4>Comentarios</h4>

    <!-- Formulario para agregar comentario -->
    <form action="{{ route('comments.store', $post) }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="form-control" placeholder="Escribe tu comentario..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Comentar</button>
    </form>

    <!-- Listado de comentarios -->
    @foreach ($post->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <p>{{ $comment->content }}</p>
                <small>Por: {{ $comment->user->name }}</small>
                @if ($comment->user_id === auth()->id())
                    <div class="mt-2">
                        <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro?')">Eliminar</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
