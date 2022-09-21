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
        /*$credentials = request()->validate([
            'email'=>'required',
            'password'=>'required'
        ],
        [
            'email.required'=>'Ingrese un email',
            'password.required'=>'Ingrese una contraseña'
        ]);*/

        //['email' => $credentials['email'], 'password' => $credentials['contrasena']

        $credentials = request()->only('email', 'password');

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return Auth::user();
        } else {
            return "No tas logiado pa";
        }
    }
}
