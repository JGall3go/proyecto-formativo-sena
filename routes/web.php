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
use App\Http\Controllers\Dashboard\LogoutController;
use App\Http\Controllers\Dashboard\ImageController;


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
    return redirect('/dashboard/home');
});

Route::get('/dashboard', function () {
    return redirect('/dashboard/home');
});

Route::resource('dashboard/home', ReporteController::class)->middleware('auth');

Route::resource('dashboard/administrador', AdministradorController::class)->middleware('auth');

Route::resource('dashboard/empleado', EmpleadoController::class)->middleware('auth');

Route::resource('dashboard/cliente', ClienteController::class)->middleware('auth');

Route::resource('dashboard/proveedor', ProveedorController::class)->middleware('auth');

Route::resource('dashboard/producto', ProductoController::class)->middleware('auth');

Route::resource('dashboard/venta', VentaController::class)->middleware('auth');

Route::resource('dashboard/login', LoginController::class);

// Route::resource('dashboard/signup', RegistroController::class);

Route::resource('dashboard/logout', LogoutController::class);


// API 

Route::resource('dashboard/imagepush', ImageController::class);