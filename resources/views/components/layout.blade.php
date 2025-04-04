<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos Coliman</title>

    <!-- Importar Bootstrap -->
    <link rel="stylesheet" href="{{ URL::asset('bootstrap-5.3.3-dist/css/bootstrap.min.css') }}" />
    <script src="{{ URL::asset('bootstrap-5.3.3-dist/js/bootstrap.min.js') }}"></script>

    <!-- Importar jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Importar DataTables -->
    <link rel="stylesheet" href="{{ URL::asset('DataTables/datatables.min.css') }}" />
    <script src="{{ URL::asset('DataTables/datatables.min.js') }}"></script>

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ URL::asset('assets/style.css') }}" />

    <!-- Cargar Vite (Laravel) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="row">
        <div class="col-2">
            @component("components.siderbar")
            @endcomponent
        </div>
        <div class="col-10">
            <div class="container">
                @section("content")
                @show
            </div>
        </div>
    </div>
</body>
</html>
