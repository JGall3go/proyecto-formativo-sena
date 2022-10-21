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
use Illuminate\Support\Facades\Http;

class ConfigController
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

            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();
            $data['ciudadesTotales'] = DB::table('ciudad')->get();
            $data['documentosTotales'] = DB::table('tipo_documento')->get();
            $data['perfilesEdit'] = Perfil::findOrFail($data['perfil']->idPerfil); // change
            $data['usuariosEdit'] = Usuario::findOrFail($data['perfilesEdit']->usuario_idUsuario);
            $data['datosContactoEdit'] = DatosContacto::where('idContacto', $data['usuariosEdit']->datos_contacto_idContacto)->firstOrFail();

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

        return view('Perfil.config', $data);
    }

    public function store(Request $request) {

        $datosContacto = Auth::user();
            
        $data['perfil'] = DB::table('perfil')
        ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
        ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
        ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
        ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
        ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
        ->select('idPerfil', 'imagen', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email')
        ->where('idContacto', $datosContacto['idContacto'])
        ->first();

        $perfiles = Perfil::findOrFail($data['perfil']->idPerfil); // change
        $usuarios = Usuario::findOrFail($perfiles->usuario_idUsuario);

        $datosContacto = DatosContacto::where('idContacto', $usuarios->datos_contacto_idContacto)
        ->firstOrFail();

        $userData = request()->validate([
            'telefono'=>'bail|required|max:10|unique:datos_contacto,telefono,'.$datosContacto->idContacto.',idContacto',
            'direccion'=>'bail|required|max:50',
            'ciudad'=>'bail|required',
            'contrasena'=>'bail|max:45',
            'nombres'=>'bail|required|max:45',
            'apellidos'=>'bail|required|max:45',
            'documento'=>'bail|required|max:45|unique:usuario,documento,'.$usuarios->idUsuario.',idUsuario',
        ],
        [
            'telefono.required'=>'Campo requerido',
            'telefono.max'=>'El campo telefono solo puede tener 10 caracteres',
            'telefono.unique'=>'Este telefono ya fue usado',

            'direccion.required'=>'Campo requerido',
            'direccion.max'=>'El campo direccion solo puede tener 50 caracteres',

            'contrasena.max'=>'La contraseña solo puede tener 45 caracteres',

            'nombres.required'=>'Campo requerido',
            'nombres.max'=>'El campo nombre solo puede tener 45 caracteres',

            'apellidos.required'=>'Campo requerido',
            'apellidos.max'=>'El campo apellido solo puede tener 45 caracteres',

            'documento.required'=>'Campo requerido',
            'documento.max'=>'El campo documento solo puede tener 45 caracteres',
            'documento.unique'=>'Este documento ya fue usado',
        ]);

        function actualizarDB($idPerfil, $userData){


            $perfil = Perfil::findOrFail($idPerfil); // change
            $usuario = Usuario::findOrFail($perfil->usuario_idUsuario);

            if($userData['contrasena'] != "") {
                
                $password = Hash::make($userData['contrasena']);
                // Actualizacion de Datos De Contacto
                $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                    'telefono' => $userData['telefono'],
                    'ciudad_idCiudad' => $userData['ciudad'],
                    'direccion' => $userData['direccion'],
                    'password' => $password
                ]);

            } else {
                
                $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                    'telefono' => $userData['telefono'],
                    'ciudad_idCiudad' => $userData['ciudad'],
                    'direccion' => $userData['direccion'],
                ]);
            }

            // Actualizacion de Usuarios
            $datosUsuario = Usuario::where('idUsuario', '=', $perfil->usuario_idUsuario)->update([
                'nombres' => $userData['nombres'],
                'apellidos' => $userData['apellidos'],
                'documento' => $userData['documento']
            ]);
        }
        
        actualizarDB($data['perfil']->idPerfil, $userData);

        // $imagen = request()->file('imagen');

        /*$client = new Client;
        $request = $client->post('http://192.168.20.24:8002/dashboard/imagepush', ['form_params' => $imagen]);

        $response = $request->send();*/

        // check file is present and has no problem uploading it
        /*if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // get Illuminate\Http\UploadedFile instance
            $image = $request->file('imagen');

            // post request with attachment
            Http::attach('attachment', file_get_contents($image), 'image.jpg')
                ->post('http://192.168.20.24:8002/dashboard/imagepush', $userData);
            error_log("si");
        } else {
            Http::post('http://192.168.20.24:8002/dashboard/imagepush', $request->all());
            error_log("no");
        }*/

        // $response = httpPost('http://192.168.20.24:8002/dashboard/imagepush', $imagen);

        return redirect('/configuracion');
    }

}
