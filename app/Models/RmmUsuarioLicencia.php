<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmmUsuarioLicencia extends Model
{
    use HasFactory;

    //Tabla
   protected $table = "rmm_usuario_licencia";

   //Timestamp
   public $timestamps = false;

   //Guarded
   protected $guarded = [];

   protected $fillable = [
      'usuario_propietario_id'
   ];

}
