<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosContacto extends Model
{
    use HasFactory;

    protected $table = "datos_contacto";
    protected $primaryKey = "idContacto";

    protected $fillable = [
        'telefono',
        'ciudadResidencia',
        'direccion',
        'email'
    ];

    public $timestamps = false;
}
