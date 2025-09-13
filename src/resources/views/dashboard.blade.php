@extends('layout.001-menu-contenedor')

@section('content')
    {{-- El div donde se montará nuestro componente Vue del Dashboard --}}
    <div id="appDashboard"></div>

    <script>
        // Pasamos los datos del usuario desde PHP (Laravel) a JavaScript
        window.userData = @json($userData);
    </script>
@endsection
