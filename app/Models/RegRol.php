<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegRol extends Model
{
    use HasFactory;
    //Tabla
    protected $table = "rmm_usuario_rol";

    //Timestamp
    public $timestamps = false;

    //Guarded
    protected $guarded = [];

    protected $fillable = [
        'rol_id',
        'usuario_id',
    ];

}
