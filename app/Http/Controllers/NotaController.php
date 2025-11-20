<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    public function index()
    {
        // Cargar usuarios con sus notas activas y recordatorios
        $users = User::with(['notas' => function($query) {
            // Usamos el scope 'activas' y cargamos las relaciones
            $query->activas()->with(['recordatorio', 'actividades']);
        }])
        ->addSelect([
            // Usamos el scope 'activas' para el conteo
            'total_notas' => Nota::selectRaw('count(*)')
                ->whereColumn('user_id', 'users.id')
                ->activas()
        ])
        ->get();

        return view('notas.index', compact('users'));
    }

    /**
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_vencimiento' => 'required|date|after_or_equal:today',
        ]);

        // Usamos una transacción para asegurar la integridad de los datos
        DB::transaction(function () use ($validated) {
            $note = Nota::create($validated);

            $note->recordatorio()->create($validated);
        });

        return redirect()->route('notas.index')->with('success', '¡Nota creada exitosamente!');
    }
}