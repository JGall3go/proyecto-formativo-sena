<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ProductoController;

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