<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UsuarioController;
use App\Http\Controllers\Dashboard\AdministradorController;
use App\Http\Controllers\Dashboard\EmpleadoController;
use App\Http\Controllers\Dashboard\ClienteController;
use App\Http\Controllers\Dashboard\ProveedorController;
use App\Http\Controllers\Dashboard\ReporteController;
use App\Http\Controllers\Dashboard\ProductoController;

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

Route::resource('dashboard/usuario', UsuarioController::class);

Route::resource('dashboard/administrador', AdministradorController::class);

Route::resource('dashboard/empleado', EmpleadoController::class);

Route::resource('dashboard/cliente', ClienteController::class);

Route::resource('dashboard/proveedor', ProveedorController::class);

Route::resource('dashboard/reporte', ReporteController::class);

Route::resource('dashboard/producto', ProductoController::class);