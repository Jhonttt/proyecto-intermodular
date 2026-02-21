<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio TFG - IES Lázaro Cárdenas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
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
            @if (!request()->routeIs('admin.login.index'))
            <nav class="header-nav" style="display: flex">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary">Usuarios</a>
                <form id="form-logout" action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <a href="#" class="btn btn-danger" onclick="document.getElementById('form-logout').submit()">Cerrar
                        Sesión</a>
                </form>
            </nav>
            @endif
            @endauth
        </div>
    </header>

    <main class="main-container">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer-top">

            <div class="footer-column">
                <b class="footer-title">Repositorios de Proyectos</b>
                <p class="footer-text">
                    Plataforma académica para compartir y descubrir proyectos estudiantiles innovadores
                </p>
            </div>

            <div class="footer-column">
                <b class="footer-title">Enlaces</b>
                <ul class="footer-links">
                    <li><a href="#">Acerca de</a></li>
                    <li><a href="#">Ayuda</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <b class="footer-title">Legal</b>
                <ul class="footer-links">
                    <li><a href="#">Términos de uso</a></li>
                    <li><a href="#">Privacidad</a></li>
                    <li><a href="#">Cookies</a></li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <div class="container">
                &copy; Proyecto Intermodular - 2 DAW. Todos los derechos reservados
            </div>
        </div>
    </footer>
</body>

</html>