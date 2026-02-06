<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de administrador')</title>
</head>

<body>

    <h1>Panel de administración</h1>

    <div id="admin-panel-container">
        @yield('content')
    </div>

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <footer>
        <span>Proyecto Intermodular 2026</span>
    </footer>

</body>

</html>