<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyDetalle extends Model
{
    use HasFactory;

    protected $table = "key_detalle";
    protected $primaryKey = "idDetalle";

    public $timestamps = false;
}
