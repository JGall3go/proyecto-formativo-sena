<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\store\CartController;/* carrito*/
use App\Http\Controllers\store\storeController;
use App\Http\Controllers\store\PagoController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Login\RegisterController;
use App\Http\Controllers\Login\LogoutController;
use App\Http\Controllers\store\PerfilController;
use App\Http\Controllers\store\ConfigController;
use App\Http\Controllers\store\BibliotecaController;
use App\Http\Controllers\store\PagoController;



Route::get('/', function () {
    return redirect()->route('store.index');
});

//Ruta para el Metodo - Pago
Route::resource('/pago', PagoController::class);
Route::get('/metodo', [PagoController::class, 'vista'])->name('pago');


Route::resource('store', storeController::class);
Route::get('store/producto/{titulo}', [storeController::class, 'ver'])->name('detalle.producto');
//Route::get('store/producto/{titulo}/metodo{idProdcto}', [storeController::class, 'vista'])->name('pago');


//Route::get('store/venta/{id}/{status}', [storeController::class, 'status'])->name('venta.status');
Route::get('/buscar', [storeController::class, 'buscar'])->name('buscar');

Route::get('/condicion', function(){
    return view('/store.terminos');
})->name('condicion');

Route::get('/fap', function(){
    return view('/store.faq');
})->name('fap');

Route::get('/politic', function(){
    return view('/store.politica');
})->name('politic');

Route::get('/prueba', function(){
    return view('/store.prueba');
})->name('prueba');

//Route::get('store', [storeController::class, 'index'])->name('shop');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index')->middleware('auth');
Route::post('/add', [CartController::class, 'add'])->name('cart.store')->middleware('auth');
Route::post('/update', [CartController::class, 'update'])->name('cart.update')->middleware('auth');
Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove')->middleware('auth');
Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear')->middleware('auth');

/*Route::resource('usuario', EmpleadoController::class);*/

/*Route::get('/pago', function(){
    return view('/store.metodo');
})->name('pago');*/

// Perfil
Route::resource('/biblioteca', BibliotecaController::class)->middleware('auth');
Route::resource('/configuracion', ConfigController::class)->middleware('auth');
 
// Login
Route::resource('/login', LoginController::class);
Route::resource('/signup', RegisterController::class);
Route::resource('/logout', LogoutController::class)->middleware('auth');
