{{-- Extiende el layout principal --}}
@extends("components.layout")

{{-- Define la sección "content" que se usará en el layout --}}
@section("content")

    {{-- Carga el componente de breadcrumbs (migas de pan) y le pasa la variable $breadcrumbs --}}
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    {{-- Contenedor del título principal --}}
    <div class="row">
        <div class="form-group my-3">
            <h1>Préstamos del empleado</h1>
        </div>
    </div>

    {{-- Contenedor con datos del empleado --}}
    <div class="card p-4">
        <div class="row">
            <div class="col-2">Empleado:</div>
            <div class="col">{{ $empleado->nombre }}</div> {{-- Muestra el nombre del empleado --}}
        </div>
    </div>

    {{-- Tabla que mostrará todos los préstamos del empleado --}}
    <table class="table" id="maintable">
        <thead>
            <tr>
                {{-- Encabezados de la tabla --}}
                <th scope="col">ID</th>
                <th scope="col">MONTO</th>
                <th scope="col">FECHA INICIO</th>
                <th scope="col">FECHA FIN</th>
                <th scope="col">ESTADO</th>
                <th scope="col">DETALLES</th>
            </tr>
        </thead>
        <tbody>
            {{-- Bucle que recorre todos los préstamos del empleado --}}
            @foreach($prestamos as $prestamo)
                <tr>
                    {{-- Muestra cada dato del préstamo --}}
                    <td class="text-center">{{ $prestamo->id_prestamo }}</td>
                    <td class="text-center">${{ number_format($prestamo->monto, 2) }}</td>
                    <td class="text-center">{{ $prestamo->fecha_ini_desc }}</td>
                    <td class="text-center">{{ $prestamo->fecha_fin_desc }}</td>
                    <td class="text-center">{{ $prestamo->estado }}</td>
                    <td class="text-center">
                        {{-- Enlace al detalle de los abonos del préstamo --}}
                        <a href="prestamos/abonos/{{ $prestamo->id_prestamo }}">Detalles</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Script de JavaScript para activar el plugin DataTable --}}
    @push('scripts')
        <script>
            // Crea la instancia del datatable con paginación y buscador
            let table = new DataTable("#maintable", {
                paging: true,      // habilita paginación
                searching: true    // habilita buscador
            });
        </script>
    @endpush

@endsection
