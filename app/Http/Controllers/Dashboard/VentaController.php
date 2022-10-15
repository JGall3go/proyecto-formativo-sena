<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Venta;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VentaController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('busqueda')) {
            $busqueda = trim($request->get('busqueda'));
        } else {
            $busqueda = "null";
        }

        $page = trim($request->get('page'));
        $registros = trim($request->get('registros'));

        /* Se comprueba si se requiere cambiar la variable de session o no */
        function actualizarSession($nuevoValor, $session, $defaultValue){
            if (session()->exists($session)) {
                if($nuevoValor != ""){ 
                    session([$session => intval($nuevoValor)]);}
            } else {
                session([$session => $defaultValue]);
            }
        }

        function actualizarBusqueda($nuevoValor, $session) {
            if (session()->exists($session)) {
                if($nuevoValor != "null"){ 
                    session([$session => $nuevoValor]);
                }
            } else {
                session([$session => '']);
            }
        }

        actualizarSession($registros, 'paginate', 5);
        actualizarBusqueda($busqueda, 'busqueda6');

        function busquedaDB($busqueda){

            $data['ventas'] = DB::table('venta')
            ->orderByRaw('idVenta')
            ->join('metodo_pago', 'metodo_pago_idMetodo', '=', 'idMetodo')
            ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
            ->select('idVenta', 'fecha', 'total', 'metodo', 'nombrePerfil')
            // Busqueda por url
            ->where('fecha', 'Like','%'.session('busqueda6').'%')
            ->orwhere('total', 'Like','%'.session('busqueda6').'%')
            ->orwhere('metodo', 'Like','%'.session('busqueda6').'%')
            ->orwhere('nombrePerfil', 'Like','%'.session('busqueda6').'%')
            ->paginate(session('paginate')); // Cantidad de registros que se van a mostrar;

            // Seleccion de proveedores
            $data['ventasTotales'] = DB::table('venta')
            ->orderByRaw('idVenta')
            ->select('idVenta')
            ->get();

            // Sistema de Permisos

            $datosContacto = Auth::user();
            
            $data['perfilUsuario'] = DB::table('perfil')
            ->leftjoin('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->leftjoin('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->leftjoin('ciudad', 'ciudad_idCiudad', 'idCiudad')
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

                if ($permiso->permiso == 'Ver Ventas') { $data['puedeVer'] = 1; }

                if ($permiso->permiso == 'Crear Ventas') { $data['puedeCrear'] = 1; }

                if ($permiso->permiso == 'Editar Ventas') { $data['puedeEditar'] = 1; }

                if ($permiso->permiso == 'Borrar Ventas') { $data['puedeBorrar'] = 1; }

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

        return view('Dashboard.Venta.index', $data, compact('busqueda', 'page'));
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

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $idVenta)
    {   

        // Variables obtenidas mediante un Request a la URL
        $busqueda = trim($request->get('busqueda'));
        $page = trim($request->get('page'));
        $registros = trim($request->get('registros'));

        $data['ventas'] = DB::table('venta')
        ->orderByRaw('idVenta')
        ->join('metodo_pago', 'metodo_pago_idMetodo', '=', 'idMetodo')
        ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
        ->select('idVenta', 'fecha', 'total', 'metodo', 'nombrePerfil')
        // Busqueda por url
        ->where('fecha', 'Like','%'.$busqueda.'%')
        ->orwhere('total', 'Like','%'.$busqueda.'%')
        ->orwhere('metodo', 'Like','%'.$busqueda.'%')
        ->orwhere('nombrePerfil', 'Like','%'.$busqueda.'%')
        ->paginate(session('paginate')); // Cantidad de registros que se van a mostrar;

        $data['ventaDetalle'] = DB::table('venta_detalle')
        ->join('producto', 'producto_idProducto', '=', 'idProducto')
        ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
        ->select('titulo', 'total', 'venta_detalle.cantidad')
        ->where('venta_idVenta', 'Like','%'.$idVenta.'%')
        ->get(); // Cantidad de registros que se van a mostrar;

        // Seleccion de proveedores
        $data['ventasTotales'] = DB::table('venta')
        ->orderByRaw('idVenta')
        ->select('idVenta')
        ->get();

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

            if ($permiso->permiso == 'Ver Ventas') { $data['puedeVer'] = 1; }

            if ($permiso->permiso == 'Crear Ventas') { $data['puedeCrear'] = 1; }

            if ($permiso->permiso == 'Editar Ventas') { $data['puedeEditar'] = 1; }

            if ($permiso->permiso == 'Borrar Ventas') { $data['puedeBorrar'] = 1; }

            if ($permiso->permiso == 'Todos Los Permisos') { 
                $data['puedeVer'] = 1;
                $data['puedeCrear'] = 1;
                $data['puedeEditar'] = 1;
                $data['puedeBorrar'] = 1;
            }
        }

        return view('Dashboard.Venta.index', $data, compact('busqueda', 'page', 'registros'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $idProducto)
    {   

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idProducto)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($idProducto)
    {  

    }
}