<?php

namespace App\Http\Controllers\store;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class storeController extends Controller
{

  public function index(Request $request)
  {

    // $resultado = busquedadBD($busqueda){
    $data['productos'] = DB::table('producto')
      ->orderByDesc('idProducto')
      ->join('linea', 'linea_idLinea', '=', 'idLinea')
      ->join('sublinea', 'sublinea_idSublinea', '=', 'idSublinea')
      ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
      ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
      ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
      ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'sublinea', 'nombrePerfil', 'estado')
      //buscador
      ->where('estado', 'Activo')
      ->get();

    $data['productosS2'] = DB::table('producto')
      ->join('linea', 'linea_idLinea', '=', 'idLinea')
      ->join('sublinea', 'sublinea_idSublinea', '=', 'idSublinea')
      ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
      ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
      ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
      ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'sublinea', 'nombrePerfil', 'estado')
      //buscador
      ->where('estado', 'Activo')
      ->get();

    // Se eliminan los productos del carrito que son inactivos
    $cartCollection = \Cart::getContent();

    foreach ($cartCollection as $producto) {
        
      $estado = DB::table('producto')
        ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
        ->select('estado')
        ->where('idProducto', 'Like', '%' . $producto->idProducto . '%')
        ->first();

      if ($estado->estado == "Inactivo") {

        \Cart::remove($producto->idProducto);
      }
    }

    return view('store.index', compact('data'));
  }

  public function buscar(Request $request)
  {

    $data = $request->all();
    $query = $data['query'] ? $data['query'] : '';

    $productos1 = [];

    if ($query != "") {
      $productos1 = DB::table('descripcion_producto')
      ->select('idDescripcion', 'titulo')
      ->where('titulo', 'LIKE', "%{$query}%")      
      ->get();

      foreach ($productos1 as $item) {
        
        $productos2 = DB::table('producto')
          ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
          ->where('descripcion_producto_idDescripcion', $item->idDescripcion)
          ->where('estado', 'Activo')
          ->get()
          ->toArray();

        $item->detalle = $productos2;
        $item->csrf = csrf_token();
      }
    }

    return redirect()->route('store.index')->with('resultado', $productos1);
  }

  public function show(Request $request, $idProducto)
  {

    $busqueda = trim($request->get('busqueda'));

    $data['productos'] = DB::table('producto')
      ->orderByRaw('idProducto')
      ->join('linea', 'linea_idLinea', '=', 'idLinea')
      ->join('sublinea', 'sublinea_idSublinea', '=', 'idSublinea')
      ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
      ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
      ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'sublinea', 'nombrePerfil')
      ->where('idProducto', 'Like', '%' . $idProducto . '%')
      ->get();

    return view('store.index',  compact('data'));
  }

  public function ver(Request $request, $titulo)
  {

    $data['productos'] = DB::table('producto')
      ->orderByRaw('idProducto')
      ->join('linea', 'linea_idLinea', '=', 'idLinea')
      ->join('sublinea', 'sublinea_idSublinea', '=', 'idSublinea')
      ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
      ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
      ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
      ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'sublinea', 'nombrePerfil', 'estado')
      ->where('titulo', 'Like', '%' . $titulo . '%')
      ->where('estado', 'Activo')
      ->first();

    return view('store.productoDetalle',  $data);
  }
}
