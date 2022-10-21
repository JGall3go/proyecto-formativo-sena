<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\DatosContacto;
use App\Models\TipoDocumento;

// Laravel Modules
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return view('Register.index');
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
     *+
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $añoActual = date('Y') - 1;
        $adultos = $añoActual - 18;

        $userData = request()->validate([
            'email'=>'bail|required|unique:datos_contacto|max:45',
            'password'=>'bail|required|min:12|max:45',
            'nombres'=>'bail|required|max:45',
            'apellidos'=>'bail|required|max:45',
            'fechaNacimiento'=> 'bail|required|date_format:Y-m-d|before_or_equal:'.$adultos.'-12-31',
            'nombrePerfil'=>'bail|required|unique:perfil|max:15',
            'tipoDocumento'=>'bail|required',
            'documento'=>'bail|required|unique:usuario|min:10|max:10|numeric',
        ],
        [

            'email.required'=>'Campo requerido',
            'email.unique'=>'Este email ya fue usado',
            'email.max'=>'El campo email solo puede tener 45 caracteres',

            'password.required'=>'Campo requerido',
            'password.max'=>'La contraseña solo puede tener 45 caracteres',
            'password.min'=>'La contraseña debe tener al menos 12 caracteres',

            'nombres.required'=>'Campo requerido',
            'nombres.max'=>'El campo nombre solo puede tener 45 caracteres',

            'apellidos.required'=>'Campo requerido',
            'apellidos.max'=>'El campo apellido solo puede tener 45 caracteres',

            'fechaNacimiento.required'=>'Campo requerido',
            'fechaNacimiento.before_or_equal'=> 'Debe ser una persona mayor de edad.',

            'nombrePerfil.required'=>'Campo requerido',
            'nombrePerfil.max'=>'El nombre de perfil solo puede tener 15 caracteres',
            'nombrePerfil.unique'=>'Este nombre de perfil ya fue usado',

            'tipoDocumento.required' => 'Campo requerido',

            'documento.required' => 'Campo requerido',
            'documento.max'=>'El campo documento solo puede tener 10 caracteres',
            'documento.min'=>'El campo documento debe tener al menos 10 caracteres',
            'documento.unique'=>'Este documento ya fue usado',
            'documento.numeric'=>'El campo documento solo puede contener numeros',
        ]);
        
        $password = Hash::make($userData['password']);

        $datosContactoInsertado = DB::table('datos_contacto')->insertGetId([ // Tabla de datos de contacto
            'email' => $userData['email'],
            'password' => $password // Password Hashed
        ]);

        $usuarioInsertado = DB::table('usuario')->insertGetId([ // Tabla de usuarios
            'imagen' => 'usuarios/default01.png',
            'nombres' => $userData['nombres'],
            'apellidos' => $userData['apellidos'],
            'fechaNacimiento' => $userData['fechaNacimiento'],
            'estado_idEstado' => '1',
            'datos_contacto_idContacto' => $datosContactoInsertado,
            'tipo_documento_idDocumento' => $userData['tipoDocumento'],
            'documento' => $userData['documento']
        ]);
        
        $perfilInsertado = DB::table('perfil')->insertGetId([
            'nombrePerfil' => $userData['nombrePerfil'],
            'usuario_idUsuario' => $usuarioInsertado,
            'rol_idRol' => '1' // Rol Automatico (1 = Cliente)
        ]);

        return redirect('/login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}