<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Usuario;
use App\Models\Perfil;
use App\Models\DatosContacto;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProveedorController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $busqueda = trim($request->get('busqueda'));
        $page = trim($request->get('page'));
        $registros = trim($request->get('registros'));

        /* Se comprueba si se requiere cambiar la variable de session o no */
        function actualizarSession($nuevoValor, $session, $defaultValue){
            if (session()->exists($session)) {
                if($nuevoValor != ""){ 
                    session([$session => intval($nuevoValor)]);}
            } else {
                session([$session => 5]);}
        }

        actualizarSession($registros, 'paginate', 5);

        function busquedaDB($busqueda){
            // $data['usuarios'] = Usuario::paginate(5);
            $data['perfiles'] = DB::table('perfil')
            ->orderByRaw('idPerfil')
            ->leftjoin('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->leftjoin('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->leftjoin('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Proveedor');})
            ->select('idPerfil', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')
            // Sistema de busqueda
            ->where('idPerfil', 'Like','%'.$busqueda.'%')
            ->orwhere('nombres', 'Like','%'.$busqueda.'%')
            ->orwhere('apellidos', 'Like','%'.$busqueda.'%')
            ->orwhere('nombrePerfil', 'Like','%'.$busqueda.'%')
            ->orwhere('fechaNacimiento', 'Like','%'.$busqueda.'%')
            ->orwhere('estado', 'Like','%'.$busqueda.'%')
            ->orwhere('telefono', 'Like','%'.$busqueda.'%')
            ->orwhere('tipoDocumento', 'Like','%'.$busqueda.'%')
            ->orwhere('documento', 'Like','%'.$busqueda.'%')
            ->orwhere('ciudad', 'Like','%'.$busqueda.'%')
            ->orwhere('direccion', 'Like','%'.$busqueda.'%')
            ->orwhere('email', 'Like','%'.$busqueda.'%')
            ->orwhere('rol', 'Like','%'.$busqueda.'%')
            ->paginate(session('paginate'));

            $data['perfilesTotales'] = DB::table('perfil')->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Proveedor');})->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();
            $data['ciudadesTotales'] = DB::table('ciudad')->get();
            $data['documentosTotales'] = DB::table('tipo_documento')->get();

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

                if ($permiso->permiso == 'Ver Proveedores') { $data['puedeVer'] = 1; }

                if ($permiso->permiso == 'Crear Proveedores') { $data['puedeCrear'] = 1; }

                if ($permiso->permiso == 'Editar Proveedores') { $data['puedeEditar'] = 1; }

                if ($permiso->permiso == 'Borrar Proveedores') { $data['puedeBorrar'] = 1; }

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

        return view('Dashboard.Proveedor.index', $data, compact('busqueda', 'page'));
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
        $userData = request()->validate([
            'telefono'=>'bail|required|unique:datos_contacto|max:10|min:10',
            'email'=>'bail|required|unique:datos_contacto|max:45',
            'contrasena'=>'bail|required|max:45',
            'nombres'=>'bail|required|max:45',
            'apellidos'=>'bail|required|max:45',
            'nombrePerfil'=>'bail|required|unique:perfil|max:15',
            'estado_idEstado'=>'bail|required',
        ],
        [
            'telefono.required'=>'Campo requerido',
            'telefono.max'=>'El campo telefono solo puede tener 10 caracteres',
            'telefono.unique'=>'Este telefono ya fue usado',

            'email.required'=>'Campo requerido',
            'email.unique'=>'Este email ya fue usado',
            'email.max'=>'El campo email solo puede tener 45 caracteres',

            'contrasena.required'=>'Campo requerido',
            'contrasena.max'=>'La contraseña solo puede tener 45 caracteres',

            'nombres.required'=>'Campo requerido',
            'nombres.max'=>'El campo nombre solo puede tener 45 caracteres',

            'apellidos.required'=>'Campo requerido',
            'apellidos.max'=>'El campo apellido solo puede tener 45 caracteres',

            'nombrePerfil.required'=>'Campo requerido',
            'nombrePerfil.max'=>'El nombre de perfil solo puede tener 15 caracteres',
            'nombrePerfil.unique'=>'Este nombre de perfil ya fue usado',

            'estado_idEstado.required'=>'Campo requerido'
        ]);
        
        $password = Hash::make($userData['contrasena']);

        $datosContactoInsertado = DB::table('datos_contacto')->insertGetId([ // Tabla de datos de contacto
            'telefono' => $userData['telefono'],
            'email' => $userData['email'],
            'password' => $password // Password Hashed
        ]);

        $usuarioInsertado = DB::table('usuario')->insertGetId([ // Tabla de usuarios
            'imagen' => 'usuarios/default01.png',
            'nombres' => $userData['nombres'],
            'apellidos' => $userData['apellidos'],
            'estado_idEstado' => $userData['estado_idEstado'],
            'datos_contacto_idContacto' => $datosContactoInsertado
        ]);
        
        $perfilInsertado = DB::table('perfil')->insertGetId([
            'nombrePerfil' => $userData['nombrePerfil'],
            'usuario_idUsuario' => $usuarioInsertado,
            'rol_idRol' => '4' // Rol Automatico (4 = Proveedor)
        ]);

        return redirect('/dashboard/proveedor');
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
    public function edit(Request $request, $idPerfil)
    {   
        $page = trim($request->get('page'));
        $params = ['page' => $page];
        $formDisplay = true;

        function busquedaDB($idPerfil){
            // $data['usuarios'] = Usuario::paginate(5);
            $data['perfiles'] = DB::table('perfil')
            ->orderByRaw('idPerfil')
            ->leftjoin('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->leftjoin('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->leftjoin('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Proveedor');})
            ->select('idPerfil', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')->paginate(session('paginate'));

            $data['perfilesEdit'] = Perfil::findOrFail($idPerfil); // change
            $data['usuariosEdit'] = Usuario::findOrFail($data['perfilesEdit']->usuario_idUsuario);
            $data['datosContactoEdit'] = DatosContacto::where('idContacto', $data['usuariosEdit']->datos_contacto_idContacto)->firstOrFail();
            
            $data['perfilesTotales'] = DB::table('perfil')->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Proveedor');})->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();
            $data['ciudadesTotales'] = DB::table('ciudad')->get();
            $data['documentosTotales'] = DB::table('tipo_documento')->get();

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

                if ($permiso->permiso == 'Ver Proveedores') { $data['puedeVer'] = 1; }

                if ($permiso->permiso == 'Crear Proveedores') { $data['puedeCrear'] = 1; }

                if ($permiso->permiso == 'Editar Proveedores') { $data['puedeEditar'] = 1; }

                if ($permiso->permiso == 'Borrar Proveedores') { $data['puedeBorrar'] = 1; }

                if ($permiso->permiso == 'Todos Los Permisos') { 
                    $data['puedeVer'] = 1;
                    $data['puedeCrear'] = 1;
                    $data['puedeEditar'] = 1;
                    $data['puedeBorrar'] = 1;
                }
            }

            return $data;
        }

        $data = busquedaDB($idPerfil);

        return view('Dashboard.Proveedor.index', $data, compact('params', 'page', 'formDisplay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idPerfil)
    {
        $perfiles = Perfil::findOrFail($idPerfil); // change
        $usuarios = Usuario::findOrFail($perfiles->usuario_idUsuario);

        $datosContacto = DatosContacto::where('idContacto', $usuarios->datos_contacto_idContacto)
        ->firstOrFail();

        $userData = request()->validate([
            'telefono'=>'bail|required|max:10|unique:datos_contacto,telefono,'.$datosContacto->idContacto.',idContacto',
            'email'=>'bail|required|max:45|unique:datos_contacto,email,'.$datosContacto->idContacto.',idContacto',
            'contrasena'=>'bail|max:45',
            'nombres'=>'bail|required|max:45',
            'apellidos'=>'bail|required|max:45',
            'nombrePerfil'=>'bail|required|max:15|unique:perfil,nombrePerfil,'.$idPerfil.',idPerfil',
            'estado_idEstado'=>'bail|required',
            'rol'=>'bail|required',
        ],
        [
            'telefono.required'=>'Campo requerido',
            'telefono.max'=>'El campo telefono solo puede tener 10 caracteres',
            'telefono.unique'=>'Este telefono ya fue usado',

            'email.required'=>'Campo requerido',
            'email.unique'=>'Este email ya fue usado',
            'email.max'=>'El campo email solo puede tener 45 caracteres',

            'contrasena.required'=>'Campo requerido',
            'contrasena.max'=>'La contraseña solo puede tener 45 caracteres',

            'nombres.required'=>'Campo requerido',
            'nombres.max'=>'El campo nombre solo puede tener 45 caracteres',

            'apellidos.required'=>'Campo requerido',
            'apellidos.max'=>'El campo apellido solo puede tener 45 caracteres',

            'nombrePerfil.required'=>'Campo requerido',
            'nombrePerfil.max'=>'El nombre de perfil solo puede tener 15 caracteres',
            'nombrePerfil.unique'=>'Este nombre de perfil ya fue usado',

            'estado_idEstado.required'=>'Campo requerido',
            'rol.required'=>'Campo requerido'
        ]);

        function actualizarDB($idPerfil, $userData){

            $perfil = Perfil::findOrFail($idPerfil); // change
            $usuario = Usuario::findOrFail($perfil->usuario_idUsuario);

            if($userData['contrasena'] != "") {
                
                $password = Hash::make($userData['contrasena']);
                // Actualizacion de Datos De Contacto
                $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                    'telefono' => $userData['telefono'],
                    'email' => $userData['email'],
                    'password' => $password
                ]);

            } else {
                
                $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                    'telefono' => $userData['telefono'],
                    'email' => $userData['email'],
                ]);
            }

            // Actualizacion de Usuarios
            $datosUsuario = Usuario::where('idUsuario', '=', $perfil->usuario_idUsuario)->update([
                'nombres' => $userData['nombres'],
                'apellidos' => $userData['apellidos'],
                'estado_idEstado' => $userData['estado_idEstado']
            ]);

            // Actualizacion de Usuarios
            $datosPerfil = Perfil::where('usuario_idUsuario', '=', $perfil->usuario_idUsuario)->update([
                'nombrePerfil' => $userData['nombrePerfil'],
                'rol_idRol' => $userData['rol']]);
        }
        
        actualizarDB($idPerfil, $userData);

        return redirect('/dashboard/proveedor/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($idPerfil)
    {
        $perfil = Perfil::findOrFail($idPerfil);
        $usuario = Usuario::findOrFail($perfil->usuario_idUsuario);

        Perfil::destroy($idPerfil);
        Usuario::destroy($perfil->usuario_idUsuario);
        DatosContacto::destroy($usuario->datos_contacto_idContacto);

        return redirect('/dashboard/proveedor');
    }
}