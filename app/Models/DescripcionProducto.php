<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescripcionProducto extends Model
{
    use HasFactory;

    protected $table = "descripcion_producto";
    protected $primaryKey = "idDescripcion";

    public $timestamps = false;
}
