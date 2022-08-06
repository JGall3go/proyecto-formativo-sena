<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosContacto extends Model
{
    use HasFactory;

    protected $table = "sublinea";
    protected $primaryKey = "idSubLinea";

    public $timestamps = false;
}
