<!DOCTYPE html>
<html lang="en">
<head>
    <!-- importar las librerías de bootstrap -->
    <link rel="stylesheet" href={{ URL::asset('bootstrap-5.3.3-dist/css/bootstrap.min.css') }} />
    
    <!-- importar los archivos JavaScript de Bootstrap-->
    <script src={{ URL::asset('bootstrap-5.3.3-dist/js/bootstrap.min.js') }}></script>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link href={{ URL::asset('DataTables/datatables.min.css') }} rel="stylesheet"/>
    <script src={{ URL::asset('DataTables/datatables.min.js') }}></script>

    
    <link href={{ URL::asset("assets/style.css") }} rel="stylesheet" />
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos Coliman</title>
</head>
</html>
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

</body>
</html>