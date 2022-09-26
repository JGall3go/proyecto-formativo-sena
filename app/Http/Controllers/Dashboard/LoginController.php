<?php

namespace App\Http\Controllers\Dashboard;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth;

class LoginController
{   

    public function index(Request $request)
    {
        return view('Dashboard.Login.index');
    }

    public function store(Request $request)
    {
        $credentials = request()->validate([
            'email'=>'required',
            'password'=>'required'
        ],
        [
            'email.required'=>'Ingrese un email',
            'password.required'=>'Ingrese una contraseña'
        ]);

        if (Auth::attempt($credentials)) {

            request()->session()->regenerate();
            
            $datosContacto = Auth::user();

            $rol = DB::table('perfil')
            ->join('usuario', 'usuario_idUsuario', '=', 'idUsuario') // Tabla de Datos de Contacto
            ->join('datos_contacto', 'datos_contacto_idContacto', '=', 'idContacto') // Tabla de Datos de Contacto
            ->join('estado', 'estado_idEstado', '=', 'idEstado') // Tabla de Estado (Activo, Inactivo)
            ->join('tipo_documento', 'tipo_documento_idDocumento', '=', 'idDocumento')
            ->join('ciudad', 'ciudad_idCiudad', 'idCiudad')
            ->join('rol', 'rol_idRol', 'idRol')
            ->select('idPerfil', 'imagen', 'nombres', 'apellidos', 'nombrePerfil', 'fechaNacimiento', 'password', 'estado', 'telefono', 'tipoDocumento', 'documento', 'ciudad', 'direccion', 'email', 'rol')
            ->where('idContacto', $datosContacto['idContacto'])
            ->first();

            if ($rol->rol == "Administrador" || $rol->rol == "Empleado" || $rol->rol == "Proveedor") {
                
                session(['username' => $rol->nombrePerfil]);
                session(['userImage' => $rol->imagen]);
                
                return redirect('/dashboard/home/');
            } else {
                Auth::logout();
                return redirect('/dashboard/login');
            }
            
        } else {
            return redirect('/dashboard/login');
        }
    }
}
