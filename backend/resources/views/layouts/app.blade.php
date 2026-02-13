<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio TFG - IES Lázaro Cárdenas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #004a99;
        }

        /* Color corporativo ficticio */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <link rel="stylesheet" href="{{ asset('backend\resources\css\app.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">IES Lázaro Cárdenas | Repositorio</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-link text-light">Hola, {{ auth()->user()->name ?? 'Usuario' }}</span>
                <a class="nav-link btn btn-danger btn-sm text-white ms-3" href="#">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <main class="main-container">
        @yield('content')
    </main>

    <footer class="text-center py-4 mt-5 text-muted">
        &copy; {{ date('Y') }} IES Lázaro Cárdenas - Proyecto Intermodular
    </footer>
</body>

</html>
