<?php

namespace App\Http\Controllers\store;

use App\Models\Usuario;
use App\Models\Perfil;
use App\Models\DatosContacto;
use Darryldecode\Cart\Cart;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Modelos
use App\Models\Keys;
use App\Models\KeyDetalle;
use App\Models\Producto;

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

                $ventasDetalle = DB::table('venta_detalle')
                ->join('venta', 'venta_idVenta', '=', 'idVenta')
                ->join('producto', 'producto_idProducto', '=', 'idProducto')
                ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
                ->select('idProducto', 'titulo', 'venta_detalle.total', 'venta_detalle.cantidad', 'imagen', 'fecha', 'valor')
                ->where('venta_idVenta', 'Like','%'.$valueVenta->idVenta.'%')
                ->get();

                foreach ($ventasDetalle as $detalle => $valueDetalle) {
                    
                    if (isset($data['productos'][$ventasDetalle[0]->idProducto])) {
                        
                        $data['productos'][$ventasDetalle[0]->idProducto]['cantidad'] = $data['productos'][$ventasDetalle[0]->idProducto]['cantidad'] + $ventasDetalle[0]->cantidad;

                    } else {

                        $data['productos'][$ventasDetalle[0]->idProducto] = [
                        
                            'idProducto' => $ventasDetalle[0]->idProducto,
                            'titulo' => $ventasDetalle[0]->titulo,
                            'total' => $ventasDetalle[0]->valor,
                            'cantidad' => $ventasDetalle[0]->cantidad,
                            'imagen' => $ventasDetalle[0]->imagen,
                            'fecha' => $ventasDetalle[0]->fecha
                        ];
                    }
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

        $cartCollection = \Cart::getContent();

        foreach ($cartCollection as $producto) {
            
            $estado = DB::table('producto')
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->select('estado')
            ->where('idProducto', 'Like', '%' . $producto->idProducto . '%')
            ->first();

            /* Si el producto se inactiva en el momento de hacer la compra
            se removera de la lista del carrito y por ende de la compra*/
            if ($estado->estado == "Inactivo") {

                \Cart::remove($producto->idProducto);
            }
        }

        return view('Perfil.biblioteca', $data);
        
        // dump($data['productos']);
    }

    public function show($tituloProducto)
    {

        $datosContacto = Auth::user();

        $perfil = DB::table('perfil')
        ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario')
        ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto')
        ->select('idPerfil')
        ->where('idContacto', $datosContacto['idContacto'])
        ->first();

        $producto = DB::table('producto')
        ->join('descripcion_producto', 'descripcion_producto_idDescripcion', '=', 'idDescripcion')
        ->select('idProducto', 'titulo')
        ->where('titulo', $tituloProducto)
        ->first();

        if ($producto == null) {
            return redirect('/biblioteca')->with(['keys' => 'null']);
        }

        $keys = Keys::where('producto_idProducto', '=', $producto->idProducto)->first();

        $keysCompradas = DB::table('key_detalle')
        ->join('keys', 'keys_idKey', '=', 'idKey')
        ->join('producto', 'producto_idProducto', '=', 'idProducto')
        ->select('idDetalle', 'key', 'key_detalle.perfil_idPerfil')
        ->where('keys_idKey', $keys->idKey)
        ->where('key_detalle.perfil_idPerfil', $perfil->idPerfil)
        ->get();

        return redirect('/biblioteca')->with(['keys' => $keysCompradas]);
    }
}