<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = "perfil";
    protected $primaryKey = "idPerfil";

    protected $fillable = [
        'nombrePerfil',
        'usuario_idUsuario',
        'rol_idRol'
    ];

    public $timestamps = false;
}
