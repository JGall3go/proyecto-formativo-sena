<?php

namespace App\Http\Controllers\Dashboard;

// Laravel Modules
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class ImageController
{	
	public function index() {
		dump(['STATUS CODE: 500']);
	}


	public function store(Request $request) {

		$imagen = $request;

		error_log($imagen);

		$request->file('imagen')->store('usuarios', 'public');

		// $request->file('imagen')->store('usuarios', 'public');
	}
}