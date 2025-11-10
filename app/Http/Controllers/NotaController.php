<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        // Cargar usuarios con sus notas activas y recordatorios
        $users = User::with(['notas' => function($query) {
            $query->with('recordatorio')
                  ->whereHas('recordatorio', function($q) {
                      $q->where('fecha_vencimiento', '>=', now())
                        ->where('completado', false);
                  });
        }])
        ->addSelect([
            'total_notas' => Nota::selectRaw('count(*)')
                ->whereColumn('user_id', 'users.id')
                ->whereHas('recordatorio', function($query) {
                    $query->where('fecha_vencimiento', '>=', now())
                          ->where('completado', false);
                })
        ])
        ->get();

        return view('notas.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_vencimiento' => 'required|date|after:now',
        ]);

        $note = Nota::create([
            'user_id' => $validated['user_id'],
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
        ]);

        $note->recordatorio()->create([
            'fecha_vencimiento' => $validated['fecha_vencimiento'],
            'completado' => false,
        ]);

        return redirect()->route('notas.index')->with('success', '¡Nota creada exitosamente!');
    }
}