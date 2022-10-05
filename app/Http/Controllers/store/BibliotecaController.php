<?php

namespace App\Http\Controllers\store;

use App\Models\Usuario;
use App\Models\Perfil;
use App\Models\DatosContacto;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BibliotecaController
{

    public function index(Request $request)
    {   
        function busquedaDB(){

            $datosContacto = Auth::user();
            
            $data['perfil'] = DB::table('perfil')
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', 'rol_idRol', 'idRol')
            ->select('idPerfil', 'imagen', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol', 'rol_idRol')
            ->where('idContacto', $datosContacto['idContacto'])
            ->first();

            $data['ventas'] = DB::table('venta')
            ->join('metodo_pago', 'metodo_pago_idMetodo', '=', 'idMetodo')
            ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil')
            ->select('idVenta', 'fecha', 'total', 'metodo', 'nombrePerfil')
            // Busqueda por url
            ->where('idPerfil', $data['perfil']->idPerfil)
            ->get();

            $data['productos'] = [];

            foreach ($data['ventas'] as $venta => $valueVenta) {

                error_log($valueVenta->fecha);

                $ventasDetalle = DB::table('venta_detalle')
                ->join('venta', 'venta_idVenta', '=', 'idVenta')
                ->join('producto', 'producto_idProducto', '=', 'idProducto')
                ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
                ->select('titulo', 'venta_detalle.total', 'venta_detalle.cantidad', 'imagen', 'fecha')
                ->where('venta_idVenta', 'Like','%'.$valueVenta->idVenta.'%')
                ->get();

                foreach ($ventasDetalle as $detalle => $valueDetalle) {
                    array_push($data['productos'], $ventasDetalle);
                }
            }

            // Seleccion de proveedores
            $data['ventasTotales'] = DB::table('venta')
            ->orderByRaw('idVenta')
            ->select('idVenta')
            ->get();

            return $data;
        }

        $data = busquedaDB();

        return view('Perfil.biblioteca', $data);
        // dump($data['productos']);
    }

}
