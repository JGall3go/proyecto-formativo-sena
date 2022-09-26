<?php

namespace App\Http\Controllers\Dashboard;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth;

class LogoutController
{   

    public function index(Request $request)
    {
        Auth::logout();
        session(['username' => '']);
        session(['userImage' => '']);
        return redirect('/dashboard/login');
    }
}
