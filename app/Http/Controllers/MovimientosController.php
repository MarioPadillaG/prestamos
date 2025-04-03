<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\Puesto;
use App\Models\Prestamo;
use App\models\Abono; // Corregido: "Prestamo" con mayúscula
use Illuminate\View\View;
use App\Models\DetEmpPuesto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon as SupportCarbon;
use DateTime;

class MovimientosController extends Controller
{
    public function prestamosGet(): View
    {
        // Corregido: "Prestamo" con mayúscula
        $prestamos = Prestamo::join("empleado", "prestamo.fk_id_empleado", "empleado.id_empleado")->get();

        return view('movimientos.prestamosGet', [
            "prestamos" => $prestamos,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos")
            ]
        ]);
    }
    public function prestamosAgregarGet(): View  
{  
    $haceunanno = (new DateTime("-1 year"))->format("Y-m-d");  
    $empleados = Empleado::where("fecha_ingreso", "<", $haceunanno)->get()->all();  
    $fecha_actual = SupportCarbon::now();  
    $prestamosvigentes = Prestamo::where("fecha_ini_desc", "<", $fecha_actual)  
        ->where("fecha_fin_desc", ">", $fecha_actual)->get()->all();  
    $empleados = array_column($empleados, null, "id_empleado");  
    $prestamosvigentes = array_column($prestamosvigentes, null, "id_empleado");  
    $empleados = array_diff_key($empleados, $prestamosvigentes);  

    return view("movimientos/prestamosAgregarGet", [  
        "empleados" => $empleados,  
        "breadcrumbs" => [  
            "Inicio" => url("/"),  
            "Préstamos" => url("/movimientos/prestamos"),  
            "Agregar" => url("/movimientos/prestamos/agregar")  
        ]  
    ]);

}
    public function prestamosAgregarPost(Request $request)
{
    $id_empleado=$request->input("id_empleado");
    $monto=$request->input("monto");
    $puesto=Puesto::join("det_emp_puesto", "puesto.id_puesto", "=", "det_emp_puesto.fk_id_puesto")
        ->where("det_emp_puesto.fk_id_empleado","=",$id_empleado)
        ->whereNull("det_emp_puesto.fecha_fin")->first();
    $sueldox6=$puesto->sueldo*6;
    if ($monto>$sueldox6){
        return view("/error",["error"=>"La solicitud excede el monto permitido"]);
    }
    $fecha_solicitud=$request->input("fecha_solicitud");
    $plazo=$request->input("plazo");
    $fecha_apro=$request->input("fecha_apro");
    $tasa_mensual=$request->input("tasa_mensual");
    $pago_fijo_cap=$request->input("pago_fijo_cap");
    $fecha_ini_desc=$request->input("fecha_ini_desc");
    $fecha_fin_desc=$request->input("fecha_fin_desc");
    $saldo_actual=$request->input("saldo_actual");
    $estado=$request->input("estado");
    $prestamo=new Prestamo([
        "fk_id_empleado"=>$id_empleado,
        "fecha_solicitud"=>$fecha_solicitud,
        "monto"=>$monto,
        "plazo"=>$plazo,
        "fecha_apro"=>$fecha_apro,
        "tasa_mensual"=>$tasa_mensual,
        "pago_fijo_cap"=>$pago_fijo_cap,
        "fecha_ini_desc"=>$fecha_ini_desc,
        "fecha_fin_desc"=>$fecha_fin_desc,
        "saldo_actual"=>$saldo_actual,
        "estado"=>$estado,
    ]);
    $prestamo->save();
    return redirect("/movimientos/prestamos"); // redirige al listado de prestamos
    }
    public function abonosGet($id_prestamo): View
    {
        $abonos = Abono::where("fk_id_prestamo", "=", $id_prestamo)->get();
    
        $prestamo = DB::table('prestamo')
            ->join('empleado', 'prestamo.fk_id_empleado', '=', 'empleado.id_empleado')
            ->where('prestamo.id_prestamo', '=', $id_prestamo)
            ->select('prestamo.*', 'empleado.nombre as empleado_nombre')
            ->first();
    
        return view("movimientos/abonosGet", [
            "abonos" => $abonos,
            "prestamo" => $prestamo,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Préstamos" => url("/movimientos/prestamos"),
                "Abonos" => url("/movimientos/prestamos/abonos/")
            ]
        ]);
    }
    public function abonosAgregarGet($id_prestamo): View
    {
        $prestamo = prestamo::join("empleado", "empleado.id_empleado", "=", "prestamo.fk_id_empleado")
            ->where("id_prestamo", $id_prestamo)->first();
    
        $abonos = abono::where("abono.fk_id_prestamo", $id_prestamo)->get();
        $num_abono = Abono::where('fk_id_prestamo', $id_prestamo)->max('num_abono') + 1;
    
        // Obtener el último abono registrado
        $ultimo_abono = abono::where("abono.fk_id_prestamo", $id_prestamo)
            ->orderBy("fecha", "desc")
            ->first();
    
        // Asegurar que tenemos un saldo inicial correcto
        $saldo_actual = $ultimo_abono ? $ultimo_abono->saldo_pendiente : $prestamo->monto_prestado;
        
        // Asegurar que tasa mensual existe
        $tasa_mensual = $prestamo->tasa_mensual ?? 0;
        
        // Calcular interés y pagos
        $monto_interes = $saldo_actual * ($tasa_mensual / 100);
        $pago_fijo_cap = $prestamo->pago_fijo_cap ?? 0;
        $monto_cobrado = $pago_fijo_cap + $monto_interes;
    
        // Calcular saldo pendiente correctamente
        $saldo_pendiente = $saldo_actual - $pago_fijo_cap;
        if ($saldo_pendiente < 0) {
            $pago_fijo_cap += $saldo_pendiente; // Ajustar pago fijo
            $saldo_pendiente = 0;
        }
    
        return view('movimientos/abonosAgregarGet', [
            'prestamo' => $prestamo,
            'num_abono' => $num_abono,
            'pago_fijo_cap' => $pago_fijo_cap,
            'monto_interes' => $monto_interes,
            'monto_cobrado' => $monto_cobrado,
            'saldo_pendiente' => $saldo_pendiente,
            'breadcrumbs' => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos"),
                "Abonos" => url("/prestamos/{$prestamo->id_prestamo}/abonos"),
                "Agregar" => "",
            ]
        ]);
    }
    public function abonosAgregarPost(Request $request, $id_prestamo)
    {
        $fecha = $request->input("fecha");
        $num_abono = $request->input("num_abono");
        $monto_capital = $request->input("monto_capital");
        $monto_interes = $request->input("monto_interes");
        $monto_cobrado = $request->input("monto_cobrado");
        $saldo_pendiente = $request->input("saldo_pendiente");
        $fk_id_prestamo = $id_prestamo;

        $abono = new Abono();
        $abono->fecha = $fecha;
        $abono->num_abono = $num_abono;
        $abono->monto_capital = $monto_capital;
        $abono->monto_interes = $monto_interes;
        $abono->monto_cobrado = $monto_cobrado;
        $abono->saldo_pendiente = $saldo_pendiente;
        $abono->fk_id_prestamo = $id_prestamo;
        
        $abono->save();
    
        return redirect("/movimientos/prestamos/{$id_prestamo}/abonos");
    }
    public function empleadosPrestamosGet(Request $request, $id_empleado): View
{
    // 1. Buscar al empleado por ID usando Eloquent
    $empleado = Empleado::find($id_empleado);

    // 2. Obtener todos los préstamos que correspondan a ese empleado
    $prestamos = Prestamo::where('fk_id_empleado', $id_empleado)->get();

    // 3. Retornar una vista y enviar los datos necesarios
    return view('movimientos/empleadosPrestamosGet', [
        // Pasar el empleado encontrado a la vista
        'empleado' => $empleado,

        // Pasar todos los préstamos del empleado a la vista
        'prestamos' => $prestamos,

        // Generar navegación tipo breadcrumbs para mostrar en la vista
        'breadcrumbs' => [
            'Inicio' => url('/'),                            // URL para el inicio
            'Prestamos' => url('/movimientos/prestamos')     // URL para la sección de préstamos
        ]
    ]);
}


}

