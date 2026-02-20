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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <header class="header">
        <div class="container header-content">
            <div class="header-left">
                <strong>
                    <a class="navbar-brand" href="{{ route('admin.proyectos.index') }}">IES Lázaro Cárdenas |
                        Repositorio</a>
                </strong>
            </div>
            @auth
                <nav class="header-nav" style="display: flex">
                    <a href="{{ route('admin.usuarios.index') }}" class="btn">Usuarios</a>
                    <form id="form-logout" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <a href="#" class="btn btn-danger" onclick="document.getElementById('form-logout').submit()">Cerrar Sesión</a>
                    </form>
                </nav>
            @endauth
        </div>
    </header>

    <main class="main-container">
        @yield('content')
    </main>

    <footer class="text-center py-4 mt-5 text-muted">
        &copy; {{ date('Y') }} IES Lázaro Cárdenas - Proyecto Intermodular
    </footer>
</body>

</html>
