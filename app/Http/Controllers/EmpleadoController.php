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
            ->join('usuario', 'perfil_usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('perfil', 'idUsuario', '=', 'usuario_idUsuario') // Tabla de Perfil
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('permisos_idPermiso', '=', '1');})
            ->select('idEmpleado', 'nombreUsuario', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'ciudadResidencia', 'direccion', 'email', 'rol')
            ->where('idEmpleado', 'Like','%'.$busqueda.'%')
            ->orwhere('nombreUsuario', 'Like','%'.$busqueda.'%')
            ->orwhere('fechaNacimiento', 'Like','%'.$busqueda.'%')
            ->orwhere('contrasena', 'Like','%'.$busqueda.'%')->paginate(session('paginate'));

            $data['empleadosTotales'] = DB::table('empleado')->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();

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
            'ciudadResidencia' => $userData['ciudadResidencia'],
            'direccion' => $userData['direccion'],
            'email' => $userData['email']
        ]);

        $usuarioInsertado = DB::table('usuario')->insertGetId([ // Tabla de usuarios
            'nombreUsuario' => $userData['nombreUsuario'],
            'fechaNacimiento' => $userData['fechaNacimiento'],
            'contrasena' => $userData['contrasena'],
            'estado_idEstado' => $userData['estado_idEstado'],
            'datos_contacto_idContacto' => $datosContactoInsertado,
        ]);
        
        $perfilInsertado = DB::table('perfil')->insertGetId([
            'nombrePerfil' => $userData['nombreUsuario'],
            'usuario_idUsuario' => $usuarioInsertado,
            'rol_idRol' => '3' // Rol Automatico (3 = Empleado)
        ]);

        $empleadoInsertado = DB::table('empleado')->insertGetId([
            'perfil_idPerfil' => $perfilInsertado,
            'perfil_usuario_idUsuario' => $usuarioInsertado
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
            ->join('usuario', 'perfil_usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('perfil', 'idUsuario', '=', 'usuario_idUsuario') // Tabla de Perfil
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('permisos_idPermiso', '=', '1');})
            ->select('idEmpleado', 'nombreUsuario', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'ciudadResidencia', 'direccion', 'email', 'rol')->paginate(session('paginate'));

            $data['empleadosEdit'] = Empleado::findOrFail($idEmpleado);
            $data['usuariosEdit'] = Usuario::findOrFail($data['empleadosEdit']->perfil_usuario_idUsuario);
            $data['datosContactoEdit'] = DatosContacto::where('idContacto', $data['usuariosEdit']->datos_contacto_idContacto)->firstOrFail();
            
            $data['empleadosTotales'] = DB::table('empleado')->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();

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

            $data['empleadosEdit'] = Empleado::findOrFail($idEmpleado);
            $usuario = Usuario::findOrFail($data['empleadosEdit']->perfil_usuario_idUsuario);

            // Actualizacion de Datos De Contacto
            $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                'telefono' => $userData['telefono'],
                'ciudadResidencia' => $userData['ciudadResidencia'],
                'direccion' => $userData['direccion'],
                'email' => $userData['email']]);

            // Actualizacion de Usuarios
            $datosUsuario = Usuario::where('idUsuario', '=', $data['empleadosEdit']->perfil_usuario_idUsuario)->update([
                'nombreUsuario' => $userData['nombreUsuario'],
                'fechaNacimiento' => $userData['fechaNacimiento'],
                'contrasena' => $userData['contrasena'],
                'estado_idEstado' => $userData['estado_idEstado']]);

            // Actualizacion de Usuarios
            $datosPerfil = Perfil::where('usuario_idUsuario', '=', $data['empleadosEdit']->perfil_usuario_idUsuario)->update([
                'nombrePerfil' => $userData['nombreUsuario'],
                'rol_idRol' => $userData['rol']]);

            if ($userData['rol'] == 1){
                Empleado::destroy($idEmpleado);
                DB::table('cliente')->insertGetId([
                    'perfil_idPerfil' => $data['empleadosEdit']->perfil_idPerfil,
                    'perfil_usuario_idUsuario' => $data['empleadosEdit']->perfil_usuario_idUsuario
                ]);
            }
            
            if ($userData['rol'] == 2){
                Empleado::destroy($idEmpleado);
                DB::table('administrador')->insertGetId([
                    'perfil_idPerfil' => $data['empleadosEdit']->perfil_idPerfil,
                    'perfil_usuario_idUsuario' => $data['empleadosEdit']->perfil_usuario_idUsuario
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
        $usuario = Usuario::findOrFail($empleado->perfil_usuario_idUsuario);

        Empleado::destroy($idEmpleado);
        Perfil::destroy($empleado->perfil_idPerfil);
        Usuario::destroy($empleado->perfil_usuario_idUsuario);
        DatosContacto::destroy($usuario->datos_contacto_idContacto);

        return redirect('/dashboard/empleado');
    }
}
