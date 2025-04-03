<?php

namespace App\Http\Controllers;

use App\models\puesto;
use Illuminate\Http\Request;
use \DataTime;
use Illuminate\view\View;
use App\models\empleado;
use App\models\det_emp_puesto;
use Carbon\Carbon;
class CatalogosController extends Controller
{
    public function home():view
    {
        return view('home',["breadcrumbs"=>[]]);
    }
    public function puestosGet(): View
    {
        $puestos = puesto::all(); // La clase 'Puesto' debe estar en mayúscula si sigue el estándar de Laravel
        return view('catalogos.puestosGet', [
            "puestos" => $puestos, 
            "breadcrumbs" => [
                    "Inicio" => URL("/"), 
                    "Puestos" => URL("/catalogo/puestos")
                ]
            ]);
        }
    public function empleadosGet(): View
    {
        $empleados = empleado::all(); // La clase 'Empleado' debe estar en mayúscula si sigue el estándar de Laravel
        return view('catalogos.empleadosGet', [
            "empleados" => $empleados, 
            "breadcrumbs" => [
                    "Inicio" => URL("/"), 
                    "Empleados" => URL("/catalogo/empleados")
                ]
            ]);
        }
    
    public function puestosAgregarGet(Request $request): View
    {
        return view('catalogos.puestosAgregarGet', [
            "breadcrumbs" => [
                    "Inicio" => URL("/"), 
                    "Puestos" => URL("/catalogo/puestos"),
                    "Agregar" => URL("/catalogo/puestos/agregar")
                ]
            ]);
        }
        public function puestosAgregarPost(Request $request)
        {
            $nombre = $request->input("nombre");
            $sueldo = $request->input("sueldo"); // Corrección en la asignación
        
            // Crear instancia del modelo Puesto
            $puesto = new Puesto([
                "nombre" => strtoupper($nombre),
                "sueldo" => $sueldo
            ]);
        
            // Guardar en la base de datos
            $puesto->save();
        
            return redirect("/catalogo/puestos");
        }
    public function empleadosAgregarGet():view
    {
        $puestos = puesto::all();
        return view('catalogos.empleadosAgregarGet', [
            "puestos" => $puestos, 
            "breadcrumbs" => [
                    "Inicio" => URL("/"), 
                    "Empleados" => URL("/catalogo/empleados"),
                    "Agregar" => URL("/catalogo/empleados/agregar")
                ]
            ]);
        }
    Public function empleadoAgregarPost(Request $request)
    {
        $nombre = $request->input("nombre");
        $fecha_ingreso = $request->input("fecha_ingreso");
        $activo = $request->input("activo");
        $empleado = new Empleado([
            "nombre" => strtoupper($nombre),
            "fecha_ingreso" => $fecha_ingreso,
            "activo" => $activo
        ]);
        $empleado->save();
        $puesto = new Det_emp_puesto([
            "fk_id_empleado" => $empleado->id_empleado,
            "fk_id_puesto" => $request->input("puesto"),
            "fecha_inicio" => $fecha_ingreso
        ]);
        $puesto->save();
        return redirect("/catalogo/empleados");
    }
    public function empleadosPuestoGet(Request $request,$id_empleado)
    {
        $puestos=Det_emp_puesto::join("puesto","puesto.id_puesto","=","det_emp_puesto.fk_id_puesto")
        ->select("Det_emp_puesto.*","puesto.nombre as puesto, puesto.sueldo")
        ->where("Det_emp_puesto.fk_id_empleado",$id_empleado)
        ->get();
        $empleado=empleado::find($id_empleado);
        return view('catalogos/empleadosPuestosGet', [
            "puestos" => $puestos, 
            "empleado" => $empleado,
            "breadcrumbs" => [
                    "Inicio" => URL("/"), 
                    "Empleados" => URL("/catalogo/empleados"),
                    "Puestos" => URL("/empleados/puestos/{id_empleado}")
                ]
            ]);
        }
    public function empleadosPuestosCambiarGet(Request $request,$id_empleado):View
    {
        $puestos = puesto::all();
        $empleado = empleado::find($id_empleado);
        return view('catalogos.empleadosPuestosCambiarGet', [
            "puestos" => $puestos, 
            "empleado" => $empleado,
            "breadcrumbs" => [
                    "Inicio" => URL("/"), 
                    "Empleados" => URL("/catalogo/empleados"),
                    "Puestos" => URL("/empleados/{id_empleado}/puestos"),
                    "Cambiar" => URL("/empleados{id_empleado}/puestos/cambiar")
                ]
            ]);
        }
    public function empleadosPuestosCambiarPost(Request $request,$id_empleado)
    {
        $fecha_inicio = $request->input("fecha_inicio");
        $fecha_fin = Carbon::parse($fecha_inicio)->subDay()->format("Y-m-d");


// Actualizar el puesto anterior si existe
        Det_emp_puesto::where("fk_id_empleado", $id_empleado)
            ->whereNull("fecha_fin")
            ->update(["fecha_fin" => $fecha_fin]);

        // Crear el nuevo puesto
        $puesto = new Det_emp_puesto([
            "fk_id_empleado" => $id_empleado,
            "fk_id_puesto" => $request->input("puesto"),
            "fecha_inicio" => $fecha_inicio
        ]);
        $puesto->save();

        return redirect("/catalogo/empleados");

    }
}
