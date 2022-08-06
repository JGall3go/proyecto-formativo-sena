<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Linea;
use App\Models\Sublinea;
use App\Models\Perfil;
use App\Models\DescripcionProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // Variables obtenidas mediante un Request a la URL
        $busqueda = trim($request->get('busqueda'));
        $page = trim($request->get('page'));
        $registros = trim($request->get('registros'));

        // Se comprueba si se requiere cambiar la variable de session o no 
        function actualizarSession($nuevoValor, $session, $defaultValue){
            if (session()->exists($session)) {
                if($nuevoValor != ""){ 
                    session([$session => intval($nuevoValor)]);}
            } else {
                session([$session => 5]);}
        }

        actualizarSession($registros, 'paginate', 5);

        function busquedaDB($busqueda){

            $data['productos'] = DB::table('producto')
            ->orderByRaw('idProducto')
            ->join('linea', 'sublinea_idSubLinea', '=', 'idLinea')
            ->join('sublinea', 'sublinea_idSubLinea', '=', 'idSubLinea')
            ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
            ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
            ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'subLinea', 'nombrePerfil')
            // Busqueda por url
            ->where('idProducto', 'Like','%'.$busqueda.'%')
            ->orwhere('titulo', 'Like','%'.$busqueda.'%')
            ->orwhere('descripcion', 'Like','%'.$busqueda.'%')
            ->orwhere('valor', 'Like','%'.$busqueda.'%')
            ->orwhere('cantidad', 'Like','%'.$busqueda.'%')
            ->orwhere('linea', 'Like','%'.$busqueda.'%')
            ->orwhere('subLinea', 'Like','%'.$busqueda.'%')
            ->orwhere('nombrePerfil', 'Like','%'.$busqueda.'%')
            ->orwhere('requisitosMinimos', 'Like','%'.$busqueda.'%')
            ->orwhere('requisitosRecomendados', 'Like','%'.$busqueda.'%')
            ->paginate(session('paginate')); // Cantidad de registros que se van a mostrar

            $data['productosTotales'] = DB::table('producto')->get();
            $data['lineasTotales'] = DB::table('linea')->get();
            $data['sublineasTotales'] = DB::table('sublinea')->get();

            // Seleccion de proveedores
            $data['proveedoresTotales'] = DB::table('perfil')
            ->orderByRaw('nombrePerfil')
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Proveedor');})
            ->select('idPerfil', 'nombrePerfil')
            ->get();

            return $data;
        }

        $data = busquedaDB($busqueda);

        return view('producto.index', $data, compact('busqueda', 'page'));
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
        $productData = request()->except('_token');

        if($request->hasFile('imagen')){
            $productData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $descripcionInsertada = DB::table('descripcion_producto')->insertGetId([
            'titulo' => $productData['titulo'],
            'descripcion' => $productData['descripcion'],
            'requisitosMinimos' => $productData['requisitosMinimos'],
            'requisitosRecomendados' => $productData['requisitosRecomendados'],
        ]);

        $productoInsertado = DB::table('producto')->insertGetId([ // Tabla de datos de contacto
            'imagen' => $productData['imagen'],
            'valor' => $productData['valor'],
            'cantidad' => $productData['cantidad'],
            'linea_idLinea' => $productData['linea'],
            'sublinea_idSubLinea' => $productData['sublinea'],
            'perfil_idPerfil' => $productData['proveedor'],
            'descripcion_producto_idDescripcion' => $descripcionInsertada,
        ]);

        $keyInsertado = DB::table('keys')->insertGetId([
            'producto_idProducto' => $productoInsertado
        ]);

        $allKeys = explode('/', $productData['keys']);
        for ($i=1; $i < count($allKeys); $i++) { 
            $keyDetaleeInsertado = DB::table('key_detalle')->insertGetId([
                'keys_idKey' => $keyInsertado,
                'key' => $allKeys[$i]
            ]);   
        };

        return redirect('dashboard/producto');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $idProducto)
    {   
        $page = trim($request->get('page'));
        $params = ['page' => $page];
        $formDisplay = true;

        function busquedaDB($idProducto){

            $data['productos'] = DB::table('producto')
            ->orderByRaw('idProducto')
            ->join('linea', 'sublinea_idSubLinea', '=', 'idLinea')
            ->join('sublinea', 'sublinea_idSubLinea', '=', 'idSubLinea')
            ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
            ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
            ->select('idProducto', 'imagen', 'titulo', 'descripcion', 'requisitosMinimos', 'requisitosRecomendados', 'valor', 'cantidad', 'linea', 'subLinea', 'nombrePerfil')
            ->paginate(session('paginate')); // Cantidad de registros que se van a mostrar

            $data['productosEdit'] = Producto::findOrFail($idProducto); // change
            $data['productosTotales'] = DB::table('producto')->get();
            
            $data['lineasTotales'] = DB::table('linea')->get();
            $data['sublineasTotales'] = DB::table('sublinea')->get();

            return $data;
        }

        $data = busquedaDB($idProducto);

        return view('producto.index', $data, compact('params', 'page', 'formDisplay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idProducto)
    {
        $productData = request()->except(['_token', '_method']);

        function actualizarDB($idProducto, $productData){

            $producto = Producto::findOrFail($idProducto);

            $descripcionProducto = DescripcionProducto::where($producto->descripcion_producto_idDescripcion)->update([
                'titulo' => $productData['titulo'],
                'descripcion' => $productData['descripcion'],
                'requisitosMinimos' => $productData['requisitosMinimos'],
                'requisitosRecomendados' => $productData['requisitosRecomendados'],
            ]);

            // Actualizacion de Datos De Contacto
            $producto = Producto::where('idProducto', '=', $idProducto)->update([
                'imagen' => $productData['imagen'],
                'valor' => $productData['valor'],
                'cantidad' => $productData['cantidad'],
                'linea_idLinea' => $productData['linea'],
                'sublinea_idSubLinea' => $productData['sublinea'],
                'perfil_idPerfil' => $productData['proveedor'],
            ]);

        }
        
        actualizarDB($idProducto, $productData);

        return redirect('/dashboard/producto/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($idProducto)
    {        
        $producto = Producto::findOrFail($idProducto);
        Producto::destroy($idProducto);
        DescripcionProducto::destroy($producto->descripcion_producto_idDescripcion);

        return redirect('/dashboard/producto');
    }
}