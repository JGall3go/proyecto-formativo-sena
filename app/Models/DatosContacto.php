<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class DatosContacto extends Model implements AuthenticatableContract {

    use Authenticatable;

    protected $table = "datos_contacto";
    protected $primaryKey = "idContacto";

    protected $fillable = [
        'telefono',
        'ciudadResidencia',
        'direccion',
        'email',
        'password'
    ];

    public $timestamps = false;
}