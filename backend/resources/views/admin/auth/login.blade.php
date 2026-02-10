<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <h1>Login Admin</h1>

    <!-- Mostrar errores si los hubiera -->
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>

        <label for="password">Contraseña</label>
        <input id="password" type="password" name="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>

</body>

</html>