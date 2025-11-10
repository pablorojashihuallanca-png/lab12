@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Alertas -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Crear Nueva Nota</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('notas.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Usuario</label>
                                    <select class="form-control" id="user_id" name="user_id" required>
                                        <option value="">Seleccionar usuario...</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                                    <input type="datetime-local" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingresa el título de la nota" required>
                        </div>
                        <div class="mb-3">
                            <label for="contenido" class="form-label">Contenido</label>
                            <textarea class="form-control" id="contenido" name="contenido" rows="4" placeholder="Escribe el contenido de tu nota..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Nota</button>
                    </form>
                </div>
            </div>

            <!-- Lista de Usuarios y sus Notas -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Notas de Usuarios</h5>
                </div>
                <div class="card-body">
                    @forelse($users as $user)
                        <div class="user-section mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-light mb-0">
                                    <strong>{{ $user->name }}</strong> 
                                    <span class="badge bg-secondary ms-2">{{ $user->total_notas }} notas activas</span>
                                </h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            
                            @if($user->notas->count() > 0)
                                <div class="row">
                                    @foreach($user->notas as $nota)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card h-100 border-light">
                                                <div class="card-body">
                                                    <h6 class="card-title text-warning">
                                                        {{ $nota->titulo_formateado }}
                                                    </h6>
                                                    <p class="card-text small">{{ Str::limit($nota->contenido, 100) }}</p>
                                                    
                                                    @if($nota->recordatorio)
                                                        <div class="mt-2">
                                                            <small class="text-info">
                                                                <strong>Vence:</strong> 
                                                                {{ $nota->recordatorio->fecha_vencimiento->format('d/m/Y H:i') }}
                                                            </small>
                                                            <br>
                                                            <small class="{{ $nota->recordatorio->completado ? 'text-success' : 'text-warning' }}">
                                                                <strong>Estado:</strong> 
                                                                {{ $nota->recordatorio->completado ? 'Completado' : 'Pendiente' }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="card-footer bg-transparent border-top-0">
                                                    <small class="text-muted">
                                                        Creado: {{ $nota->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-secondary text-center py-2">
                                    <small class="text-muted">Este usuario no tiene notas activas.</small>
                                </div>
                            @endif
                        </div>
                        
                        @if(!$loop->last)
                            <hr class="border-secondary">
                        @endif
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted">No hay usuarios con notas registradas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.user-section {
    background: rgba(255, 255, 255, 0.05);
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #1f8c5d;
}

.card.border-light {
    background: #5a8a6fff;
    border: 1px solid #375b46 !important;
    transition: transform 0.2s ease;
}

.card.border-light:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.badge {
    font-size: 0.7em;
}

.text-muted {
    color: #a8b2ab !important;
}

.text-info {
    color: #6bcae2 !important;
}

.text-warning {
    color: #e9c46a !important;
}

.text-success {
    color: #2a9d8f !important;
}
</style>
@endsection