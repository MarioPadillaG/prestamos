<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\MovimientosController;
use Francerz\PowerData\Index;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\loginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home',["breadcrumbs"=>[]]);
});
route::get("/catalogo/puestos",[CatalogosController::class,"puestosGet"]);
route::get("/catalogo/empleados",[CatalogosController::class,"empleadosGet"]);
route::get("/catalogo/puestos/agregar",[CatalogosController::class,"puestosAgregarGet"]);
route::post("/catalogo/puestos/agregar",[CatalogosController::class,"puestosAgregarPost"]);
route::get("/catalogo/empleados/agregar",[catalogosController::class,"empleadosAgregarGet"]);
route::post("/catalogo/empleados/",[catalogosController::class,"empleadoAgregarPost"]);{
Route::get('/catalogo/puestos/{id_empleado}', [CatalogosController::class, 'empleadosPuestoGet'])
    ->where('id_empleado', '[0-9]+');
}
Route::get('/empleados/{id_empleado}/puestos/cambiar', [CatalogosController::class, 'empleadosPuestosCambiarGet'])
    ->where('id_empleado', '[0-9]+');

Route::post('/empleados/{id_empleado}/puestos/cambiar', [CatalogosController::class, 'empleadosPuestosCambiarPost'])
    ->where('id_empleado', '[0-9]+');

Route::get("/reportes",[ReportesController::class,"indexGet"]);
Route::get("/reportes/prestamos-activos",[ReportesController::class,"prestamosActivosGet"]);

Route::get("/movimientos/prestamos",[MovimientosController::class,"prestamosGet"]);
Route::get("/movimientos/prestamos/agregar",[MovimientosController::class,"prestamosAgregarGet"]);
route::post("/movimientos/prestamos/agregar",[MovimientosController::class,"prestamosAgregarPost"]);
route::get("/movimientos/prestamos/{id_prestamo}/abonos",[MovimientosController::class,"AbonosGet"]);
route::get("/prestamos/{id_prestamo}/abonos/agregar",[MovimientosController::class,"AbonosAgregarGet"]);
Route::post('/prestamos/{id}/abonos/agregar', [MovimientosController::class, 'abonosAgregarPost']);
Route::get('/movimientos/empleados/{id}', [MovimientosController::class, 'empleadosPrestamosGet']);
route::get('/reportes/matriz-abonos',[ReportesController::class,"matrizAbonosGet"]);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);