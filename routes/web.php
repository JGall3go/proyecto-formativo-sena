<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\EmpleadoController;


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

Route::get('dashboard/empleado', function () {
    return view('empleado/index');
})->name('empleado');

Route::get('/cliente', function () {
    return view('cliente/index');
})->name('cliente');

Route::get('/producto', function () {
    return view('producto/index');
})->name('producto');

Route::get('/venta', function () {
    return view('venta/index');
})->name('venta');

Route::get('/proveedor', function () {
    return view('proveedor/index');
})->name('proveedor');

Route::get('/reporte', function () {
    return view('reporte/index');
})->name('reporte');

Route::get('/categoria', function () {
    return view('categoria/index');
})->name('categoria');

Route::get('/clasificacion', function () {
    return view('clasificacion/index');
})->name('clasificacion');

Route::get('/metodoDePago', function () {
    return view('metodo/index');
})->name('metodo');

Route::get('/estado', function () {
    return view('estado/index');
})->name('estado');

/*Route::resource('usuario', EmpleadoController::class);*/