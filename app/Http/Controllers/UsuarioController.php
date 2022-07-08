<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Perfil;
use App\Models\DatosContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
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
        function actualizarSession($nuevoValor, $session){
            if (session()->exists($session)) {
                if($nuevoValor != ""){ 
                    session([$session => intval($nuevoValor)]);}
            } else {
                session([$session => 5]);}
        }

        actualizarSession($registros, 'paginate');

        function busquedaDB($busqueda){
            // $data['usuarios'] = Usuario::paginate(5);
            $data['usuarios'] = DB::table('usuario')
            ->orderByRaw('idUsuario')
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('perfil', 'idUsuario', '=', 'usuario_idUsuario') // Tabla de Perfil
            ->join('rol', function ($join) {$join->on('idRol', '=', 'rol_idRol')->where('permisos_idPermiso', '=', '1');})
            ->select('idUsuario', 'nombreUsuario', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'ciudadResidencia', 'direccion', 'email', 'rol')
            ->where('idUsuario', 'Like','%'.$busqueda.'%')
            ->orwhere('nombreUsuario', 'Like','%'.$busqueda.'%')
            ->orwhere('fechaNacimiento', 'Like','%'.$busqueda.'%')
            ->orwhere('contrasena', 'Like','%'.$busqueda.'%' )->paginate(session('paginate'));

            $data['usuariosTotales'] = DB::table('usuario')->get();

            return $data;
        }

        $data = busquedaDB($busqueda);

        return view('usuario.index', $data, compact('busqueda', 'page'));
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
            'rol_idRol' => '1' // Acomodar roles con respecto al menu
        ]);

        return redirect('dashboard/usuario');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $idUsuario)
    {   
        $page = trim($request->get('page'));
        $params = ['page' => $page];

        function busquedaDB($idUsuario){
            // $data['usuarios'] = Usuario::paginate(5);
            $data['usuarios'] = DB::table('usuario')
            ->orderByRaw('idUsuario')
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('perfil', 'idUsuario', '=', 'usuario_idUsuario') // Tabla de Perfil
            ->join('rol', 'idRol', '=', 'rol_idRol') // Tabla de Roles (Cliente, Empleado, Administrador)
            ->select('idUsuario', 'nombreUsuario', 'fechaNacimiento', 'contrasena', 'estado', 'telefono', 'ciudadResidencia', 'direccion', 'email', 'rol')->paginate(session('paginate'));

            $data['usuariosTotales'] = DB::table('usuario')->get();
            $data['usuariosEdit'] = Usuario::findOrFail($idUsuario);
            $data['datosContactoEdit'] = DatosContacto::where('idContacto', $data['usuariosEdit']->datos_contacto_idContacto)->firstOrFail();

            return $data;
        }

        $data = busquedaDB($idUsuario);

        return view('usuario.index', $data, compact('params', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idUsuario)
    {
        $userData = request()->except(['_token', '_method']);

        function actualizarDB($idUsuario, $userData){

            $data['usuariosEdit'] = Usuario::findOrFail($idUsuario);

            // Actualizacion de Datos De Contacto
            $datosContacto = DatosContacto::where('idContacto', '=', $data['usuariosEdit']->datos_contacto_idContacto)->update([
                'telefono' => $userData['telefono'],
                'ciudadResidencia' => $userData['ciudadResidencia'],
                'direccion' => $userData['direccion'],
                'email' => $userData['email']]);

            // Actualizacion de Usuarios
            $datosUsuario = Usuario::where('idUsuario', '=', $idUsuario)->update([
                'nombreUsuario' => $userData['nombreUsuario'],
                'fechaNacimiento' => $userData['fechaNacimiento'],
                'contrasena' => $userData['contrasena'],
                'estado_idEstado' => $userData['estado_idEstado'],
                'datos_contacto_idContacto' => $data['usuariosEdit']->datos_contacto_idContacto,]);

            // Actualizacion de Usuarios
            $datosPerfil = Perfil::where('usuario_idUsuario', '=', $idUsuario)->update([
                'nombrePerfil' => $userData['nombreUsuario'],
                'usuario_idUsuario' => $idUsuario,
                'rol_idRol' => '1']);
        }
        
        actualizarDB($idUsuario, $userData);

        return redirect('/dashboard/usuario/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($idUsuario)
    {

        Usuario::destroy($idUsuario);
        return redirect('/dashboard/usuario');
    }
}
