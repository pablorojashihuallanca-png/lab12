<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Solo usuarios logueados
    }

    // Guardar un comentario
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Comentario creado.');
    }

    // Mostrar formulario de edición
    public function edit(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        return view('comments.edit', compact('comment'));
    }

    // Actualizar comentario
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $comment->post)->with('success', 'Comentario actualizado.');
    }

    // Eliminar comentario
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $comment->delete();

        return redirect()->route('posts.show', $comment->post)->with('success', 'Comentario eliminado.');
    }
}
