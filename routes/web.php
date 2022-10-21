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

use App\Http\Controllers\store\CartController;
use App\Http\Controllers\store\storeController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Login\RegisterController;
use App\Http\Controllers\Login\LogoutController;
use App\Http\Controllers\store\PerfilController;
use App\Http\Controllers\store\ConfigController;
use App\Http\Controllers\store\BibliotecaController;
use App\Http\Controllers\store\PagoController;

use App\Mail\PurchaseResponse;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return redirect()->route('store.index');
});

//Ruta para el Metodo - Pago
Route::resource('/checkout', PagoController::class)->middleware('auth');
Route::post('/checkout/status', [PagoController::class, 'show'])->middleware('auth');

Route::resource('store', storeController::class);
Route::get('store/producto/{titulo}', [storeController::class, 'ver'])->name('detalle.producto');

//Route::get('store/venta/{id}/{status}', [storeController::class, 'status'])->name('venta.status');
Route::get('/buscar', [storeController::class, 'buscar'])->name('buscar');
// Route::get('/biblioteca/buscar', [BibliotecaController::class, 'buscar']);

//Route::get('store', [storeController::class, 'index'])->name('shop');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
Route::post('/add', [CartController::class, 'add'])->name('cart.store');
Route::post('/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');

// Perfil
Route::resource('/biblioteca', BibliotecaController::class)->middleware('auth');
Route::resource('/configuracion', ConfigController::class)->middleware('auth');
 
// Login
Route::resource('/login', LoginController::class);
Route::resource('/signup', RegisterController::class);
Route::resource('/logout', LogoutController::class)->middleware('auth');

/* Informacion de la Tienda */
Route::get('/terminos', function(){
    return view('/store.terminos');
})->name('condicion');

Route::get('/faq', function(){
    return view('/store.faq');
})->name('faq');

Route::get('/politic', function(){
    return view('/store.politica');
})->name('politic');