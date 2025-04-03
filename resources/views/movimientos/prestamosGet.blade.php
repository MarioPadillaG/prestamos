@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <div class="row my-4">
        <div class="col">
            <h1>Préstamos</h1>
        </div>
        <div class="col-auto titlebar-comands">
            <a class="btn btn-primary" href="{{ url('/movimientos/prestamos/agregar') }}">Agregar</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" id="maintable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Empleado</th>
                    <th scope="col">FECHA DE SOLICITUD</th>
                    <th scope="col">MONTO</th>
                    <th scope="col">PLAZO</th>
                    <th scope="col">FECHA APROBACIÓN</th>
                    <th scope="col">TASA MENSUAL</th>
                    <th scope="col">PAGO FIJO CAPITAL</th>
                    <th scope="col">FECHA INICIO DESCUENTO</th>
                    <th scope="col">FECHA FIN DESCUENTO</th>
                    <th scope="col">SALDO ACTUAL</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">ABONOS</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($prestamos as $prestamo)
                <tr>
                    <td class="text-center">{{ $prestamo->id_prestamo }}</td>
                    <td class="text-center">{{ $prestamo->nombre }}</td>
                    <td class="text-center">{{ $prestamo->fecha_solicitud }}</td>
                    <td class="text-center">{{ $prestamo->monto }}</td>
                    <td class="text-center">{{ $prestamo->plazo }}</td>
                    <td class="text-center">{{ $prestamo->fecha_apro }}</td>
                    <td class="text-center">{{ $prestamo->tasa_mensual }}</td>
                    <td class="text-center">{{ $prestamo->pago_fijo_cap }}</td>
                    <td class="text-center">{{ $prestamo->fecha_ini_desc }}</td>
                    <td class="text-center">{{ $prestamo->fecha_fin_desc }}</td>
                    <td class="text-center">{{ $prestamo->saldo_actual }}</td>
                    <td class="text-center">{{ $prestamo->estado }}</td>
                    <td class="text-center">
                        <a href="{{ url("/movimientos/prestamos/{$prestamo->id_prestamo}/abonos") }}">Abonos</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
