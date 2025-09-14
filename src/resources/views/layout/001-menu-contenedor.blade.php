<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seguro App</title>

    <script>
        window.Laravel = {
            userData: @json(session('user_data')),
            nestjsToken: @json(session('nestjs_token')),
            // --- LÍNEA AÑADIDA ---
            // Usamos la función route() de Laravel para generar la URL de forma segura
            urlPermisos: '{{ route('user.menu') }}'
        };
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <main>
        @yield('content')
    </main>
</body>
</html>
