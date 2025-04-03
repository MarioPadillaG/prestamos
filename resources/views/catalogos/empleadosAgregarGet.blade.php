@extends("components.layout")

@section("content")

{{-- Breadcrumbs --}}
@include("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])

<div class="container mt-4">
    <div class="form-group my-3">
        <h1 class="mb-4">Agregar empleado</h1>
    </div>

    {{-- Formulario --}}
    <form method="post" action="{{ url('/catalogo/empleados/') }}">
        @csrf {{-- Token de seguridad en formularios --}}

        <div class="row my-4">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>
                <input type="text" maxlength="50" name="nombre" id="nombre" 
                    placeholder="Ingrese nombre del empleado" class="form-control" required autofocus>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="fecha_ingreso">Fecha de ingreso:</label>
                <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
            </div>
        </div>

        <div class="row my-3">
            <div class="form-group col-md-6">
                <label for="puesto">Puesto:</label>
                <select name="puesto" id="puesto" class="form-control" required>
                    @foreach($puestos as $puesto)
                        <option value="{{ $puesto->id_puesto }}">{{ $puesto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="activo">Activo:</label>
                <select name="activo" id="activo" class="form-control" required>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>

        {{-- Botón de enviar --}}
        <button type="submit" class="btn btn-primary mt-3">Guardar</button>

    </form>
</div>
@endsection
