<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $table = "administrador";
    protected $primaryKey = "idAdministrador";

    protected $fillable = [
        'perfil_idPerfil',
        'perfil_usuario_idUsuario'
    ];

    public $timestamps = false;
}
