<?php

namespace App\Http\Controllers\store;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class storeController extends Controller
{

  public function index(Request $request)
  {

    $busqueda = trim($request->get(''));

    // $resultado = busquedadBD($busqueda){
    $data['productos'] = DB::table('producto')
      ->orderByDesc('idProducto')
      ->join('linea', 'linea_idLinea', '=', 'idLinea')
      ->join('sublinea', 'sublinea_idSublinea', '=', 'idSublinea')
      ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
      ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
      ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'sublinea', 'nombrePerfil')
      //buscador
      ->where('idProducto', 'like', '%' . $busqueda . '%')
      ->orWhere('titulo', 'like', '%' . $busqueda . '%')
      ->orWhere('descripcion', 'like', '%' . $busqueda . '%')
      ->orWhere('valor', 'like', '%' . $busqueda . '%')
      ->orWhere('cantidad', 'like', '%' . $busqueda . '%')
      ->orWhere('linea', 'like', '%' . $busqueda . '%')
      ->orWhere('sublinea', 'like', '%' . $busqueda . '%')
      ->orWhere('nombrePerfil', 'like', '%' . $busqueda . '%')
      ->orWhere('requisitosMinimos', 'like', '%' . $busqueda . '%')
      ->orWhere('requisitosRecomendados', 'like', '%' . $busqueda . '%')
      ->get();

    $data['productosS2'] = DB::table('producto')
      ->join('linea', 'linea_idLinea', '=', 'idLinea')
      ->join('sublinea', 'sublinea_idSublinea', '=', 'idSublinea')
      ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
      ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
      ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'sublinea', 'nombrePerfil')
      //buscador
      ->where('idProducto', 'like', '%' . $busqueda . '%')
      ->orWhere('titulo', 'like', '%' . $busqueda . '%')
      ->orWhere('descripcion', 'like', '%' . $busqueda . '%')
      ->orWhere('valor', 'like', '%' . $busqueda . '%')
      ->orWhere('cantidad', 'like', '%' . $busqueda . '%')
      ->orWhere('linea', 'like', '%' . $busqueda . '%')
      ->orWhere('sublinea', 'like', '%' . $busqueda . '%')
      ->orWhere('nombrePerfil', 'like', '%' . $busqueda . '%')
      ->orWhere('requisitosMinimos', 'like', '%' . $busqueda . '%')
      ->orWhere('requisitosRecomendados', 'like', '%' . $busqueda . '%')
      ->get();

    // $data = busquedadBD($busqueda);
    //dd($data['productos']);
    return view('store.index',  compact('data'));
  }

  public function buscar(Request $request)
  {

    $data = $request->all();
      
     // if ($data['busqueda'] != null) {
       // dd('hola');
        $query = $data['query'] ? $data['query'] : '';
        $productos1 = DB::table('descripcion_producto')->select('idDescripcion','titulo')->where('titulo', 'LIKE', "%{$query}%")->get();
        foreach ($productos1 as $item) {
          $productos2 = DB::table('producto')->where('descripcion_producto_idDescripcion',$item->idDescripcion)->get()->toArray();
          $item->detalle = $productos2;
          $item->csrf = csrf_token();
        }
      //}
      //else{
      //  $productos1 = DB::table('descripcion_producto')->select('idDescripcion','titulo')->get();
      //}
     // dd($data['busqueda']);
     
      
     
  
    return response()->json($productos1->toArray());
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
    //dump($data['productos']);
  }

  public function ver(Request $request, $titulo)
  {

    $data['productos'] = DB::table('producto')
      ->orderByRaw('idProducto')
      ->join('linea', 'linea_idLinea', '=', 'idLinea')
      ->join('sublinea', 'sublinea_idSublinea', '=', 'idSublinea')
      ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
      ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
      ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'sublinea', 'nombrePerfil')
      ->where('titulo', 'Like', '%' . $titulo . '%')
      ->first();

    return view('store.productoDetalle',  $data);
    //dump($data['productos']);
  }
}
