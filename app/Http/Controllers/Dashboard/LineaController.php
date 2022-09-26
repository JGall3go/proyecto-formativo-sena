<?php

namespace App\Http\Controllers\Dashboard;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Linea;
use App\Models\Sublinea;

class LineaController
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

            $data['lineas'] = DB::table('linea')
            ->orderByRaw('idLinea')
            ->select('idLinea', 'linea')
            // Busqueda por url
            ->where('idLinea', 'Like','%'.$busqueda.'%')
            ->orwhere('linea', 'Like','%'.$busqueda.'%')
            ->paginate(session('paginate')); // Cantidad de registros que se van a mostrar

            $data['lineasTotales'] = DB::table('linea')->get();
            $data['sublineasTotales'] = DB::table('sublinea')->get();

            // Sistema de Permisos

            $datosContacto = Auth::user();
            
            $data['perfilUsuario'] = DB::table('perfil')
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', 'rol_idRol', 'idRol')
            ->select('idPerfil', 'imagen', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol', 'rol_idRol')
            ->where('idContacto', $datosContacto['idContacto'])
            ->first();

            $data['permisos'] = DB::table('rol_detalle')
            ->join('permisos', 'permisos_idPermiso', 'idPermiso')
            ->select('permiso')
            ->where('rol_idRol', $data['perfilUsuario']->rol_idRol)
            ->get();

            $data['puedeVer'] = 0;
            $data['puedeCrear'] = 0;
            $data['puedeEditar'] = 0;
            $data['puedeBorrar'] = 0;

            foreach ($data['permisos'] as $permiso) {

                if ($permiso->permiso == 'Ver Productos') { $data['puedeVer'] = 1; }

                if ($permiso->permiso == 'Crear Productos') { $data['puedeCrear'] = 1; }

                if ($permiso->permiso == 'Editar Productos') { $data['puedeEditar'] = 1; }

                if ($permiso->permiso == 'Borrar Productos') { $data['puedeBorrar'] = 1; }

                if ($permiso->permiso == 'Todos Los Permisos') { 
                    $data['puedeVer'] = 1;
                    $data['puedeCrear'] = 1;
                    $data['puedeEditar'] = 1;
                    $data['puedeBorrar'] = 1;
                }
            }
            
            return $data;
        }

        $data = busquedaDB($busqueda);

        return view('Dashboard.Linea.index', $data, compact('busqueda', 'page'));
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
        $lineaData = request()->validate([
            'linea'=>'bail|required|max:45',
        ],
        [
            'linea.required'=>'Campo requerido',
            'linea.max'=>'El campo linea solo puede tener 45 caracteres',
        ]);

        $linea = DB::table('linea')->insertGetId([
            'linea' => $lineaData['linea']
        ]);

        return redirect('/dashboard/linea');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $idLinea)
    {   
        $page = trim($request->get('page'));
        $params = ['page' => $page];
        $formDisplay = true;

        function busquedaDB($idLinea){

            $data['lineas'] = DB::table('linea')
            ->orderByRaw('idLinea')
            ->select('idLinea', 'linea')
            ->paginate(session('paginate')); // Cantidad de registros que se van a mostrar

            $data['lineasEdit'] = Linea::findOrFail($idLinea);
            $data['lineasTotales'] = DB::table('linea')->get();

            // Sistema de Permisos

            $datosContacto = Auth::user();
            
            $data['perfilUsuario'] = DB::table('perfil')
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', 'rol_idRol', 'idRol')
            ->select('idPerfil', 'imagen', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol', 'rol_idRol')
            ->where('idContacto', $datosContacto['idContacto'])
            ->first();

            $data['permisos'] = DB::table('rol_detalle')
            ->join('permisos', 'permisos_idPermiso', 'idPermiso')
            ->select('permiso')
            ->where('rol_idRol', $data['perfilUsuario']->rol_idRol)
            ->get();

            $data['puedeVer'] = 0;
            $data['puedeCrear'] = 0;
            $data['puedeEditar'] = 0;
            $data['puedeBorrar'] = 0;

            foreach ($data['permisos'] as $permiso) {

                if ($permiso->permiso == 'Ver Productos') { $data['puedeVer'] = 1; }

                if ($permiso->permiso == 'Crear Productos') { $data['puedeCrear'] = 1; }

                if ($permiso->permiso == 'Editar Productos') { $data['puedeEditar'] = 1; }

                if ($permiso->permiso == 'Borrar Productos') { $data['puedeBorrar'] = 1; }

                if ($permiso->permiso == 'Todos Los Permisos') { 
                    $data['puedeVer'] = 1;
                    $data['puedeCrear'] = 1;
                    $data['puedeEditar'] = 1;
                    $data['puedeBorrar'] = 1;
                }
            }

            return $data;
        }

        $data = busquedaDB($idLinea);

        return view('Dashboard.Linea.index', $data, compact('params', 'page', 'formDisplay'));
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

        // Si hay una imagen diferente se elimina la anterior y se pone la nueva.
        $producto = Producto::where('idProducto', '=', $idProducto)->first();
        if($request->hasFile('imagen')){
            Storage::disk('public')->delete($producto->imagen);
            $productData['imagen'] = $request->file('imagen')->store('productos', 'public');
        } else {
            $productData['imagen'] = $producto->imagen;
        }

        function actualizarDB($idProducto, $productData){

            // Optimizar

            $producto = Producto::findOrFail($idProducto);

            $descripcionProducto = DescripcionProducto::where('idDescripcion', '=', $producto->descripcion_producto_idDescripcion)->update([
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
                'sublinea_idSublinea' => $productData['sublinea'],
                'perfil_idPerfil' => $productData['proveedor'],
            ]);

            $keys = Keys::where('producto_idProducto', '=', $idProducto)->first();
            $keyDetalle = KeyDetalle::where('keys_idKey', '=', $keys->idKey)->get();

            // Se eliminan todas las keys viejas
            for ($key = 0; $key < count($keyDetalle); $key++) { // Se elimina cada Key
                KeyDetalle::destroy($keyDetalle[$key]->idDetalle);
            }

            // Se agregan las nuevas keys junto a las viejas
            $allKeys = explode('/', $productData['keys']);
            for ($i=1; $i < count($allKeys); $i++) { 
                DB::table('key_detalle')->insert([
                    'keys_idKey' => $keys->idKey,
                    'key' => $allKeys[$i]
                ]);
            };
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
        $producto = Producto::where('idProducto', '=', $idProducto)->first();
        $keys = Keys::where('producto_idProducto', '=', $idProducto)->first();

        if(count($keys) > 0){

            $keyDetalle = KeyDetalle::where('keys_idKey', '=', $keys->idKey)->get();

            for ($key = 0; $key < count($keyDetalle); $key++) { // Se elimina cada Key
                KeyDetalle::destroy($keyDetalle[$key]->idDetalle);
            }

            Keys::destroy($keys->idKey);
        }

        // Se elimina la imagen del producto y el producto
        Storage::disk('public')->delete($producto->imagen);
        Producto::destroy($idProducto);
        DescripcionProducto::destroy($producto->descripcion_producto_idDescripcion);

        return redirect('/dashboard/producto');
    }
}