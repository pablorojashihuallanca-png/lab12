@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Actividad @if($actividad->nota) de la Nota: "{{ $actividad->nota->titulo }}" @endif</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('actividades.update', $actividad) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', $actividad->descripcion) }}" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado">
                <option value="pendiente" @selected(old('estado', $actividad->estado) == 'pendiente')>Pendiente</option>
                <option value="en progreso" @selected(old('estado', $actividad->estado) == 'en progreso')>En Progreso</option>
                <option value="completada" @selected(old('estado', $actividad->estado) == 'completada')>Completada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Actividad</button>
        <a href="{{ route('notas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection