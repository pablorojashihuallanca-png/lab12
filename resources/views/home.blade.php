@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>You are logged in!</p>

                    <!-- Botón para ir a publicaciones -->
                    <a href="{{ route('posts.index') }}" class="btn btn-primary mt-3">
                        Ir a Publicaciones
                    </a>
                    
                    <!-- Botón para ir a notas -->
                    <a href="{{ route('notas.index') }}" class="btn btn-success mt-3 ms-2">
                        Ir a Notas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
