<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados tipo DeviantArt -->
    <style>
        body {
            background-color: #3a4441ff;
            color: #e3e3e3;
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background-color: #1b3326 !important;
            border-bottom: 2px solid #1f5130;
        }

        .navbar-brand, .nav-link, .dropdown-item {
            color: #a8f0b0 !important;
        }

        .nav-link:hover, .dropdown-item:hover {
            color: #6af587 !important;
        }

        .card {
            background-color: #7faa7fff;
            border: 1px solid #234d33;
            box-shadow: 0 0 12px rgba(0, 255, 128, 0.1);
            border-radius: 8px;
        }

        .card-header {
            background-color: #203a2d;
            color: #a8f0b0;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #1f8c5d;
            border: none;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #29b071;
        }

        .btn-secondary {
            background-color: #2b2f2d;
            color: #a8f0b0;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #3a433f;
        }

        .btn-warning {
            background-color: #708c2a;
            border: none;
        }

        .btn-danger {
            background-color: #803030;
            border: none;
        }

        .form-control, textarea {
            background-color: #63726bff;
            color: #e3e3e3;
            border: 1px solid #375b46;
        }

        .form-control:focus {
            border-color: #2fb36c;
            box-shadow: 0 0 0 0.2rem rgba(47, 179, 108, 0.25);
        }

        a {
            color: #47c97b;
            text-decoration: none;
        }

        a:hover {
            color: #6df8a5;
        }

        .alert-success {
            background-color: #153e2b;
            color: #a8f0b0;
            border-color: #1f5130;
        }

        h1, h5 {
            color: #c2f5cb;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end bg-dark">
                                    <a class="dropdown-item text-light" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
