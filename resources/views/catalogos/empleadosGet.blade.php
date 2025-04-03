@extends("components.layout") 
@section("content") 

@component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs]) 
@endcomponent  

<div class="row my-4">
    <div class="col">
        <h1>Empleados</h1>
    </div>
    <div class="col-auto titlebar-commands">
        <a class="btn btn-primary" href="{{ url('/catalogo/empleados/agregar') }}">Agregar</a>
    </div>
</div>

<table class="table" id="maintable">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Fecha ingreso</th>
            <th scope="col">Activo</th>
            <th scope="col">Acciones</th> <!-- Nueva columna -->
        </tr>
    </thead>
    <tbody>
        @foreach($empleados as $empleado)
        <tr>
            <td class="text-center">{{$empleado->id_empleado}}</td>
            <td class="text-center">{{$empleado->nombre}}</td>
            <td class="text-center">{{$empleado->fecha_ingreso}}</td>
            <td class="text-center">{{$empleado->activo}}</td>
            <td class="text-center">
                <a href="{{ url('/catalogo/puestos/'.$empleado->id_empleado) }}" class="btn btn-info btn-sm">Puestos</a>
                <a href="{{ url('/movimientos/empleados/'.$empleado->id_empleado) }}" class="btn btn-secondary btn-sm">prestamos</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    let table = new DataTable('#maintable', { paging: true, searching: true });
</script>

@endsection

