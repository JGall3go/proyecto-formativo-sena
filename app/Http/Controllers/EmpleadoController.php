<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Usuario;
use App\Models\Perfil;
use App\Models\DatosContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
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
            $data['empleados'] = DB::table('empleado')
            ->orderByRaw('idEmpleado')
            ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil') // Tabla de Perfil // change
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('permisos_idPermiso', '=', '1');})
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->select('idEmpleado', 'nombres', 'apellidos', 'nombreUsuario', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')
            ->where('idEmpleado', 'Like','%'.$busqueda.'%')
            ->orwhere('nombreUsuario', 'Like','%'.$busqueda.'%')
            ->orwhere('fechaNacimiento', 'Like','%'.$busqueda.'%')
            ->orwhere('contrasena', 'Like','%'.$busqueda.'%')->paginate(session('paginate'));

            $data['empleadosTotales'] = DB::table('empleado')->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();
            $data['ciudadesTotales'] = DB::table('ciudad')->get();
            $data['documentosTotales'] = DB::table('tipo_documento')->get();

            return $data;
        }

        $data = busquedaDB($busqueda);

        return view('empleado.index', $data, compact('busqueda', 'page'));
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
            'nombres' => $userData['nombres'],
            'apellidos' => $userData['apellidos'],
            'nombreUsuario' => $userData['nombreUsuario'],
            'fechaNacimiento' => $userData['fechaNacimiento'],
            'contrasena' => $userData['contrasena'],
            'estado_idEstado' => $userData['estado_idEstado'],
            'datos_contacto_idContacto' => $datosContactoInsertado,
            'tipo_documento_idDocumento' => $userData['tipoDocumento'],
            'documento' => $userData['documento']
        ]);
        
        $perfilInsertado = DB::table('perfil')->insertGetId([
            'nombrePerfil' => $userData['nombreUsuario'],
            'usuario_idUsuario' => $usuarioInsertado,
            'rol_idRol' => '3' // Rol Automatico (3 = Empleado)
        ]);

        $empleadoInsertado = DB::table('empleado')->insertGetId([
            'perfil_idPerfil' => $perfilInsertado,
        ]);

        return redirect('dashboard/empleado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $idEmpleado)
    {   
        $page = trim($request->get('page'));
        $params = ['page' => $page];

        function busquedaDB($idEmpleado){
            // $data['usuarios'] = Usuario::paginate(5);
            $data['empleados'] = DB::table('empleado')
            ->orderByRaw('idEmpleado')
            ->join('perfil', 'perfil_idPerfil', '=', 'idPerfil') // Tabla de Perfil // change
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('permisos_idPermiso', '=', '1');})
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->select('idEmpleado', 'nombres', 'apellidos', 'nombreUsuario', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')->paginate(session('paginate'));

            $data['empleadosEdit'] = Empleado::findOrFail($idEmpleado);
            $perfil = Perfil::findOrFail($data['empleadosEdit']->perfil_idPerfil); // change
            $data['usuariosEdit'] = Usuario::findOrFail($perfil->usuario_idUsuario);
            $data['datosContactoEdit'] = DatosContacto::where('idContacto', $data['usuariosEdit']->datos_contacto_idContacto)->firstOrFail();
            
            $data['empleadosTotales'] = DB::table('empleado')->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();
            $data['ciudadesTotales'] = DB::table('ciudad')->get();
            $data['documentosTotales'] = DB::table('tipo_documento')->get();

            return $data;
        }

        $data = busquedaDB($idEmpleado);

        return view('empleado.index', $data, compact('params', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idEmpleado)
    {
        $userData = request()->except(['_token', '_method']);

        function actualizarDB($idEmpleado, $userData){

            $empleado = Empleado::findOrFail($idEmpleado);
            $perfil = Perfil::findOrFail($empleado->perfil_idPerfil); // change
            $usuario = Usuario::findOrFail($perfil->usuario_idUsuario);

            $table = "";
            if($userData['rol'] == 1){$table = "cliente";}
            if($userData['rol'] == 2){$table = "administrador";}
            if($userData['rol'] == 3){$table = "empleado";}
            if($userData['rol'] == 4){$table = "proveedor";}

            // Actualizacion de Datos De Contacto
            $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                'telefono' => $userData['telefono'],
                'ciudadResidencia' => $userData['ciudadResidencia'],
                'direccion' => $userData['direccion'],
                'email' => $userData['email']]);

            // Actualizacion de Usuarios
            $datosUsuario = Usuario::where('idUsuario', '=', $perfil->usuario_idUsuario)->update([
                'nombreUsuario' => $userData['nombreUsuario'],
                'fechaNacimiento' => $userData['fechaNacimiento'],
                'contrasena' => $userData['contrasena'],
                'estado_idEstado' => $userData['estado_idEstado']]);

            // Actualizacion de Usuarios
            $datosPerfil = Perfil::where('usuario_idUsuario', '=', $perfil->usuario_idUsuario)->update([
                'nombrePerfil' => $userData['nombreUsuario'],
                'rol_idRol' => $userData['rol']]);

            if($userData['rol'] != 3){
                Empleado::destroy($idEmpleado);
                DB::table($table)->insertGetId([
                    'perfil_idPerfil' => $empleado->perfil_idPerfil,
                ]);
            }
        }
        
        actualizarDB($idEmpleado, $userData);

        return redirect('/dashboard/empleado/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($idEmpleado)
    {
        $empleado = Empleado::findOrFail($idEmpleado);
        $perfil = Perfil::findOrFail($empleado->perfil_idPerfil);
        $usuario = Usuario::findOrFail($perfil->usuario_idUsuario);

        Empleado::destroy($idEmpleado);
        Perfil::destroy($empleado->perfil_idPerfil);
        Usuario::destroy($perfil->usuario_idUsuario);
        DatosContacto::destroy($usuario->datos_contacto_idContacto);

        return redirect('/dashboard/empleado');
    }
}
