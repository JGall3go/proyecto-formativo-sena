<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdministradorController;
use App\Http\Controllers\Dashboard\EmpleadoController;
use App\Http\Controllers\Dashboard\ClienteController;
use App\Http\Controllers\Dashboard\ProveedorController;
use App\Http\Controllers\Dashboard\ReporteController;
use App\Http\Controllers\Dashboard\ProductoController;
use App\Http\Controllers\Dashboard\VentaController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\RegistroController;


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
    return view('welcome');
});

Route::resource('dashboard/home', ReporteController::class);

Route::resource('dashboard/administrador', AdministradorController::class);

Route::resource('dashboard/empleado', EmpleadoController::class);

Route::resource('dashboard/cliente', ClienteController::class);

Route::resource('dashboard/proveedor', ProveedorController::class);

Route::resource('dashboard/producto', ProductoController::class);

Route::resource('dashboard/venta', VentaController::class);

Route::resource('dashboard/login', LoginController::class);

Route::resource('dashboard/signup', RegistroController::class);