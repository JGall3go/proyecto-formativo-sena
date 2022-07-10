<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Usuario;
use App\Models\Perfil;
use App\Models\DatosContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministradorController extends Controller
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
            $data['administradores'] = DB::table('administrador')
            ->orderByRaw('idAdministrador')
            ->join('usuario', 'perfil_usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('perfil', 'idUsuario', '=', 'usuario_idUsuario') // Tabla de Perfil
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('permisos_idPermiso', '=', '1');})
            ->select('idAdministrador', 'nombreUsuario', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'ciudadResidencia', 'direccion', 'email', 'rol')
            ->where('idAdministrador', 'Like','%'.$busqueda.'%')
            ->orwhere('nombreUsuario', 'Like','%'.$busqueda.'%')
            ->orwhere('fechaNacimiento', 'Like','%'.$busqueda.'%')
            ->orwhere('contrasena', 'Like','%'.$busqueda.'%')->paginate(session('paginate'));

            $data['administradoresTotales'] = DB::table('administrador')->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();

            return $data;
        }

        $data = busquedaDB($busqueda);

        return view('administrador.index', $data, compact('busqueda', 'page'));
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
            'rol_idRol' => '2' // Rol Automatico (2 = Administrador)
        ]);

        $administradorInsertado = DB::table('administrador')->insertGetId([
            'perfil_idPerfil' => $perfilInsertado,
            'perfil_usuario_idUsuario' => $usuarioInsertado
        ]);

        return redirect('dashboard/administrador');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrador  $Administrador
     * @return \Illuminate\Http\Response
     */
    public function show(Administrador $administrador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Administrador  $Administrador
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $idAdministrador)
    {   
        $page = trim($request->get('page'));
        $params = ['page' => $page];

        function busquedaDB($idAdministrador){
            // $data['usuarios'] = Usuario::paginate(5);
            $data['administradores'] = DB::table('administrador')
            ->orderByRaw('idAdministrador')
            ->join('usuario', 'perfil_usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('perfil', 'idUsuario', '=', 'usuario_idUsuario') // Tabla de Perfil
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('permisos_idPermiso', '=', '1');})
            ->select('idAdministrador', 'nombreUsuario', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'ciudadResidencia', 'direccion', 'email', 'rol')->paginate(session('paginate'));

            $data['administradoresEdit'] = Administrador::findOrFail($idAdministrador);
            $data['usuariosEdit'] = Usuario::findOrFail($data['administradoresEdit']->perfil_usuario_idUsuario);
            $data['datosContactoEdit'] = DatosContacto::where('idContacto', $data['usuariosEdit']->datos_contacto_idContacto)->firstOrFail();
            
            $data['administradoresTotales'] = DB::table('administrador')->get();
            $data['rolesTotales'] = DB::table('rol')->get();
            $data['estadosTotales'] = DB::table('estado')->get();

            return $data;
        }

        $data = busquedaDB($idAdministrador);

        return view('administrador.index', $data, compact('params', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administrador  $Administrador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idAdministrador)
    {
        $userData = request()->except(['_token', '_method']);

        function actualizarDB($idAdministrador, $userData){

            $data['administradoresEdit'] = Administrador::findOrFail($idAdministrador);
            $usuario = Usuario::findOrFail($data['administradoresEdit']->perfil_usuario_idUsuario);

            // Actualizacion de Datos De Contacto
            $datosContacto = DatosContacto::where('idContacto', '=', $usuario->datos_contacto_idContacto)->update([
                'telefono' => $userData['telefono'],
                'ciudadResidencia' => $userData['ciudadResidencia'],
                'direccion' => $userData['direccion'],
                'email' => $userData['email']]);

            // Actualizacion de Usuarios
            $datosUsuario = Usuario::where('idUsuario', '=', $data['administradoresEdit']->perfil_usuario_idUsuario)->update([
                'nombreUsuario' => $userData['nombreUsuario'],
                'fechaNacimiento' => $userData['fechaNacimiento'],
                'contrasena' => $userData['contrasena'],
                'estado_idEstado' => $userData['estado_idEstado']]);

            // Actualizacion de Usuarios
            $datosPerfil = Perfil::where('usuario_idUsuario', '=', $data['administradoresEdit']->perfil_usuario_idUsuario)->update([
                'nombrePerfil' => $userData['nombreUsuario'],
                'rol_idRol' => $userData['rol']]);
            
            if ($userData['rol'] == 1){
                Administrador::destroy($idAdministrador);
                DB::table('cliente')->insertGetId([
                    'perfil_idPerfil' => $data['administradoresEdit']->perfil_idPerfil,
                    'perfil_usuario_idUsuario' => $data['administradoresEdit']->perfil_usuario_idUsuario
                ]);
            }
            
            if ($userData['rol'] == 3){
                Administrador::destroy($idAdministrador);
                DB::table('empleado')->insertGetId([
                    'perfil_idPerfil' => $data['administradoresEdit']->perfil_idPerfil,
                    'perfil_usuario_idUsuario' => $data['administradoresEdit']->perfil_usuario_idUsuario
                ]);
            }
                
        }
        
        actualizarDB($idAdministrador, $userData);

        return redirect('/dashboard/administrador/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrador  $Administrador
     * @return \Illuminate\Http\Response
     */
    public function destroy($idAdministrador)
    {
        $administrador = Administrador::findOrFail($idAdministrador);
        $usuario = Usuario::findOrFail($administrador->perfil_usuario_idUsuario);

        Administrador::destroy($idAdministrador);
        Perfil::destroy($administrador->perfil_idPerfil);
        Usuario::destroy($administrador->perfil_usuario_idUsuario);
        DatosContacto::destroy($usuario->datos_contacto_idContacto);

        return redirect('/dashboard/administrador');
    }
}
