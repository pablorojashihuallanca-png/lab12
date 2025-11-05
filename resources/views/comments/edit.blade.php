@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Comentario</h1>

    <form action="{{ route('comments.update', $comment) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <textarea name="content" class="form-control" required>{{ $comment->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('posts.show', $comment->post) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
