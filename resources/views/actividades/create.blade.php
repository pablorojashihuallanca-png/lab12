@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Actividad a la Nota: "{{ $nota->titulo }}"</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notas.actividades.store', $nota) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado">
                <option value="pendiente" selected>Pendiente</option>
                <option value="en progreso">En Progreso</option>
                <option value="completada">Completada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Actividad</button>
        <a href="{{ route('notas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection