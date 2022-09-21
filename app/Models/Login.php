<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;

    protected $table = "usuario";
    protected $primaryKey = "idUsuario";

    protected $fillable = [
        'nombreUsuario',
        'fechaNacimiento',
        'contrasena',
        'estado_idEstado',
        'datos_contacto_idContacto',
    ];

    public $timestamps = false;

    public function email()
    {
        return $this->hasOne(DatosContacto::class);
    }

}
