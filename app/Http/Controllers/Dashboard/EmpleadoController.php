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

class EmpleadoController
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
                session([$session => $defaultValue]);}
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
        actualizarBusqueda($busqueda, 'busqueda2');

        function busquedaDB($busqueda){
            // $data['usuarios'] = Usuario::paginate(5);
            $data['perfiles'] = DB::table('perfil')
            ->orderByRaw('idPerfil')
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Empleado');})
            ->select('idPerfil', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')
            ->where('nombres', 'Like','%'.session('busqueda2').'%')
            ->orwhere('apellidos', 'Like','%'.session('busqueda2').'%')
            ->orwhere('nombrePerfil', 'Like','%'.session('busqueda2').'%')
            ->orwhere('fechaNacimiento', 'Like','%'.session('busqueda2').'%')
            ->orwhere('estado', 'Like','%'.session('busqueda2').'%')
            ->orwhere('telefono', 'Like','%'.session('busqueda2').'%')
            ->orwhere('tipoDocumento', 'Like','%'.session('busqueda2').'%')
            ->orwhere('documento', 'Like','%'.session('busqueda2').'%')
            ->orwhere('ciudad', 'Like','%'.session('busqueda2').'%')
            ->orwhere('direccion', 'Like','%'.session('busqueda2').'%')
            ->orwhere('email', 'Like','%'.session('busqueda2').'%')
            ->orwhere('rol', 'Like','%'.session('busqueda2').'%')
            ->paginate(session('paginate'));

            $data['perfilesTotales'] = DB::table('perfil')->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Empleado');})->get();

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

                if ($permiso->permiso == 'Ver Empleados') { $data['puedeVer'] = 1; }

                if ($permiso->permiso == 'Crear Empleados') { $data['puedeCrear'] = 1; }

                if ($permiso->permiso == 'Editar Empleados') { $data['puedeEditar'] = 1; }

                if ($permiso->permiso == 'Borrar Empleados') { $data['puedeBorrar'] = 1; }

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

        if (intval($page) > 0) {
            $countPage = intval($page) - 1;
        } else {
            $countPage = 0;
        }

        $count = $countPage * session('paginate');
        foreach ($data['perfiles'] as $key => $value) {
            $count++;
            $value->idContinua = $count;
        }

        return view('Dashboard.Empleado.index', $data, compact('busqueda', 'page'));

        // dd($data['perfiles']);
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
        $añoActual = date('Y') - 1;
        $adultos = $añoActual - 18;

        $userData = request()->validate([
            'telefono'=>'bail|required|unique:datos_contacto|max:10|numeric',
            'direccion'=>'bail|required|max:50',
            'email'=>'bail|required|unique:datos_contacto|max:45',
            'ciudad'=>'bail|required',
            'contrasena'=>'bail|required|max:45',
            'nombres'=>'bail|required|max:45|',
            'apellidos'=>'bail|required|max:45|',
            'fechaNacimiento'=> 'bail|required|date_format:Y-m-d|before_or_equal:'.$adultos.'-12-31',
            'tipoDocumento'=>'bail|required|numeric',
            'documento'=>'bail|required|unique:usuario|max:45',
            'nombrePerfil'=>'bail|required|unique:perfil|max:15',
        ],
        [
            'telefono.required'=>'Campo requerido',
            'telefono.max'=>'El campo telefono solo puede tener 10 caracteres',
            'telefono.unique'=>'Este telefono ya fue usado',

            'direccion.required'=>'Campo requerido',
            'direccion.max'=>'El campo direccion solo puede tener 50 caracteres',

            'email.required'=>'Campo requerido',
            'email.unique'=>'Este email ya fue usado',
            'email.max'=>'El campo email solo puede tener 45 caracteres',

            'ciudad.required'=>'Campo requerido',

            'contrasena.required'=>'Campo requerido',
            'contrasena.max'=>'La contraseña solo puede tener 45 caracteres',

            'nombres.required'=>'Campo requerido',
            'nombres.max'=>'El campo nombre solo puede tener 45 caracteres',

            'apellidos.required'=>'Campo requerido',
            'apellidos.max'=>'El campo apellido solo puede tener 45 caracteres',

            'fechaNacimiento.required'=>'Campo requerido',
            'fechaNacimiento.before_or_equal'=> 'Debe ser una persona mayor de edad.',
            'tipoDocumento.required'=>'Campo requerido',

            'documento.required'=>'Campo requerido',
            'documento.max'=>'El campo documento solo puede tener 45 caracteres',
            'documento.unique'=>'Este documento ya fue usado',

            'nombrePerfil.required'=>'Campo requerido',
            'nombrePerfil.max'=>'El nombre de perfil solo puede tener 15 caracteres',
            'nombrePerfil.unique'=>'Este nombre de perfil ya fue usado',
        ]);
        
        $password = Hash::make($userData['contrasena']);

        $datosContactoInsertado = DB::table('datos_contacto')->insertGetId([ // Tabla de datos de contacto
            'telefono' => $userData['telefono'],
            'direccion' => $userData['direccion'],
            'email' => $userData['email'],
            'ciudad_idCiudad' => $userData['ciudad'],
            'password' => $password
        ]);

        $usuarioInsertado = DB::table('usuario')->insertGetId([ // Tabla de usuarios
            'imagen' => 'usuarios/default01.png',
            'nombres' => $userData['nombres'],
            'apellidos' => $userData['apellidos'],
            'fechaNacimiento' => $userData['fechaNacimiento'],
            'estado_idEstado' => 1,
            'datos_contacto_idContacto' => $datosContactoInsertado,
            'tipo_documento_idDocumento' => $userData['tipoDocumento'],
            'documento' => $userData['documento']
        ]);
        
        $perfilInsertado = DB::table('perfil')->insertGetId([
            'nombrePerfil' => $userData['nombrePerfil'],
            'usuario_idUsuario' => $usuarioInsertado,
            'rol_idRol' => '3' // Rol Automatico (3 = Empleado)
        ]);

        return redirect('/dashboard/empleado');
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
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Empleado');})
            ->select('idPerfil', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')
            ->where('nombres', 'Like','%'.session('busqueda2').'%')
            ->orwhere('apellidos', 'Like','%'.session('busqueda2').'%')
            ->orwhere('nombrePerfil', 'Like','%'.session('busqueda2').'%')
            ->orwhere('fechaNacimiento', 'Like','%'.session('busqueda2').'%')
            ->orwhere('estado', 'Like','%'.session('busqueda2').'%')
            ->orwhere('telefono', 'Like','%'.session('busqueda2').'%')
            ->orwhere('tipoDocumento', 'Like','%'.session('busqueda2').'%')
            ->orwhere('documento', 'Like','%'.session('busqueda2').'%')
            ->orwhere('ciudad', 'Like','%'.session('busqueda2').'%')
            ->orwhere('direccion', 'Like','%'.session('busqueda2').'%')
            ->orwhere('email', 'Like','%'.session('busqueda2').'%')
            ->paginate(session('paginate'));

            $data['perfilesEdit'] = Perfil::findOrFail($idPerfil); // change
            $data['usuariosEdit'] = Usuario::findOrFail($data['perfilesEdit']->usuario_idUsuario);
            $data['datosContactoEdit'] = DatosContacto::where('idContacto', $data['usuariosEdit']->datos_contacto_idContacto)->firstOrFail();
            
            $data['perfilesTotales'] = DB::table('perfil')->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Empleado');})->get();
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

                if ($permiso->permiso == 'Ver Empleados') { $data['puedeVer'] = 1; }

                if ($permiso->permiso == 'Crear Empleados') { $data['puedeCrear'] = 1; }

                if ($permiso->permiso == 'Editar Empleados') { $data['puedeEditar'] = 1; }

                if ($permiso->permiso == 'Borrar Empleados') { $data['puedeBorrar'] = 1; }

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

        if (intval($page) > 0) {
            $countPage = intval($page) - 1;
        } else {
            $countPage = 0;
        }

        $count = $countPage * session('paginate');
        foreach ($data['perfiles'] as $key => $value) {
            $count++;
            $value->idContinua = $count;
        }

        return view('Dashboard.Empleado.index', $data, compact('params', 'page', 'formDisplay'));
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

        $añoActual = date('Y') - 1;
        $adultos = $añoActual - 18;

        $userData = request()->validate([
            'telefono'=>'bail|required|max:10|unique:datos_contacto,telefono,'.$datosContacto->idContacto.',idContacto',
            'direccion'=>'bail|required|max:50',
            'email'=>'bail|required|max:45|unique:datos_contacto,email,'.$datosContacto->idContacto.',idContacto',
            'ciudad'=>'bail|required',
            'contrasena'=>'bail|max:45',
            'nombres'=>'bail|required|max:45',
            'apellidos'=>'bail|required|max:45',
            'fechaNacimiento'=> 'bail|required|date_format:Y-m-d|before_or_equal:'.$adultos.'-12-31',
            'tipoDocumento'=>'bail|required',
            'documento'=>'bail|required|max:45|unique:usuario,documento,'.$usuarios->idUsuario.',idUsuario',
            'nombrePerfil'=>'bail|required|max:15|unique:perfil,nombrePerfil,'.$idPerfil.',idPerfil',
            'estado_idEstado'=>'bail|required',
            'rol'=>'bail|required',
        ],
        [
            'telefono.required'=>'Campo requerido',
            'telefono.max'=>'El campo telefono solo puede tener 10 caracteres',
            'telefono.unique'=>'Este telefono ya fue usado',

            'direccion.required'=>'Campo requerido',
            'direccion.max'=>'El campo direccion solo puede tener 50 caracteres',

            'email.required'=>'Campo requerido',
            'email.unique'=>'Este email ya fue usado',
            'email.max'=>'El campo email solo puede tener 45 caracteres',

            'ciudad.required'=>'Campo requerido',

            'contrasena.required'=>'Campo requerido',
            'contrasena.max'=>'La contraseña solo puede tener 45 caracteres',

            'nombres.required'=>'Campo requerido',
            'nombres.max'=>'El campo nombre solo puede tener 45 caracteres',

            'apellidos.required'=>'Campo requerido',
            'apellidos.max'=>'El campo apellido solo puede tener 45 caracteres',

            'fechaNacimiento.required'=>'Campo requerido',
            'fechaNacimiento.before_or_equal'=> 'Debe ser una persona mayor de edad.',
            'tipoDocumento.required'=>'Campo requerido',

            'documento.required'=>'Campo requerido',
            'documento.max'=>'El campo documento solo puede tener 45 caracteres',
            'documento.unique'=>'Este documento ya fue usado',

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
                    'ciudad_idCiudad' => $userData['ciudad'],
                    'direccion' => $userData['direccion'],
                    'email' => $userData['email'],
                    'password' => $password
                ]);

            } else {
                
                $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                    'telefono' => $userData['telefono'],
                    'ciudad_idCiudad' => $userData['ciudad'],
                    'direccion' => $userData['direccion'],
                    'email' => $userData['email'],
                ]);
            }

            // Actualizacion de Usuarios
            $datosUsuario = Usuario::where('idUsuario', '=', $perfil->usuario_idUsuario)->update([
                'imagen' => 'usuarios/default01.png',
                'nombres' => $userData['nombres'],
                'apellidos' => $userData['apellidos'],
                'fechaNacimiento' => $userData['fechaNacimiento'],
                'estado_idEstado' => $userData['estado_idEstado'],
                'tipo_documento_idDocumento' => $userData['tipoDocumento'],
                'documento' => $userData['documento']
            ]);

            // Actualizacion de Usuarios
            $datosPerfil = Perfil::where('usuario_idUsuario', '=', $perfil->usuario_idUsuario)->update([
                'nombrePerfil' => $userData['nombrePerfil'],
                'rol_idRol' => $userData['rol']]);
        }
        
        actualizarDB($idPerfil, $userData);

        return redirect('/dashboard/empleado/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($idPerfil)
    {
        $perfil = Perfil::findOrFail($idPerfil); // change    

        // Actualizacion de Usuarios
        Usuario::where('idUsuario', '=', $perfil->usuario_idUsuario)->update([
            'estado_idEstado' => 2,
        ]);

        return redirect('/dashboard/empleado');
    }
}
