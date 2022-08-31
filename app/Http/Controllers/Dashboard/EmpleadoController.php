<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Usuario;
use App\Models\Perfil;
use App\Models\DatosContacto;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmpleadoController
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
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Empleado');})
            ->select('idPerfil', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')
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

            $data['perfilesTotales'] = DB::table('perfil')->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Empleado');})->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();
            $data['ciudadesTotales'] = DB::table('ciudad')->get();
            $data['documentosTotales'] = DB::table('tipo_documento')->get();

            return $data;
        }

        $data = busquedaDB($busqueda);

        return view('Dashboard.Empleado.index', $data, compact('busqueda', 'page'));
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
        $userData = request()->except('_token');

        $datosContactoInsertado = DB::table('datos_contacto')->insertGetId([ // Tabla de datos de contacto
            'telefono' => $userData['telefono'],
            'direccion' => $userData['direccion'],
            'email' => $userData['email'],
            'ciudad_idCiudad' => $userData['ciudad']
        ]);

        $usuarioInsertado = DB::table('usuario')->insertGetId([ // Tabla de usuarios
            'imagen' => 'usuarios/default01.png',
            'nombres' => $userData['nombres'],
            'apellidos' => $userData['apellidos'],
            'fechaNacimiento' => $userData['fechaNacimiento'],
            'contrasena' => $userData['contrasena'],
            'estado_idEstado' => $userData['estado_idEstado'],
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
            ->select('idPerfil', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')->paginate(session('paginate'));

            $data['perfilesEdit'] = Perfil::findOrFail($idPerfil); // change
            $data['usuariosEdit'] = Usuario::findOrFail($data['perfilesEdit']->usuario_idUsuario);
            $data['datosContactoEdit'] = DatosContacto::where('idContacto', $data['usuariosEdit']->datos_contacto_idContacto)->firstOrFail();
            
            $data['perfilesTotales'] = DB::table('perfil')->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('rol', '=', 'Empleado');})->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();
            $data['ciudadesTotales'] = DB::table('ciudad')->get();
            $data['documentosTotales'] = DB::table('tipo_documento')->get();

            return $data;
        }

        $data = busquedaDB($idPerfil);

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
        $userData = request()->except(['_token', '_method']);

        function actualizarDB($idPerfil, $userData){

            $perfil = Perfil::findOrFail($idPerfil); // change
            $usuario = Usuario::findOrFail($perfil->usuario_idUsuario);

            // Actualizacion de Datos De Contacto
            $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                'telefono' => $userData['telefono'],
                'ciudad_idCiudad' => $userData['ciudad'],
                'direccion' => $userData['direccion'],
                'email' => $userData['email']]);

            // Actualizacion de Usuarios
            $datosUsuario = Usuario::where('idUsuario', '=', $perfil->usuario_idUsuario)->update([
                'imagen' => 'usuarios/default01.png',
                'nombres' => $userData['nombres'],
                'apellidos' => $userData['apellidos'],
                'fechaNacimiento' => $userData['fechaNacimiento'],
                'contrasena' => $userData['contrasena'],
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
        $perfil = Perfil::findOrFail($idPerfil);
        $usuario = Usuario::findOrFail($perfil->usuario_idUsuario);

        Perfil::destroy($idPerfil);
        Usuario::destroy($perfil->usuario_idUsuario);
        DatosContacto::destroy($usuario->datos_contacto_idContacto);

        return redirect('/dashboard/empleado');
    }
}
