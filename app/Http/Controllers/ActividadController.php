<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Nota;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /**
     * Muestra el formulario para crear una nueva actividad para una nota.
     */
    public function create(Nota $nota)
    {
        return view('actividades.create', compact('nota'));
    }

    /**
     * Guarda una nueva actividad en la base de datos.
     */
    public function store(Request $request, Nota $nota)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|string|in:pendiente,en progreso,completada',
        ]);

        $nota->actividades()->create($validated);

        return redirect()->route('notas.index')->with('success', 'Actividad agregada a la nota.');
    }

    /**
     * Muestra el formulario para editar una actividad.
     */
    public function edit(Actividad $actividad)
    {
        return view('actividades.edit', compact('actividad'));
    }

    /**
     * Actualiza una actividad específica.
     */
    public function update(Request $request, Actividad $actividad)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|string|in:pendiente,en progreso,completada',
        ]);

        $actividad->update($validated);

        return redirect()->route('notas.index')->with('success', 'Actividad actualizada.');
    }

    /**
     * Elimina una actividad.
     */
    public function destroy(Actividad $actividad)
    {
        $actividad->delete();
        return redirect()->route('notas.index')->with('success', 'Actividad eliminada.');
    }
}