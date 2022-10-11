<?php

namespace App\Http\Controllers\store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vista(Request $request, $idProducto)
    {
    
      $dato['productos'] = DB::table('producto')

      ->orderByRaw('idProducto')
      ->join('linea', 'linea_idLinea', '=', 'idLinea')
      ->join('sublinea', 'sublinea_idSublinea', '=', 'idSublinea')
      ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
      ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
      ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'sublinea', 'nombrePerfil')
      ->where('idProducto', 'Like', '%' . $idProducto . '%')
      ->first();
   //dump($dato['productos']);
   return view('store.metodo', $dato);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
