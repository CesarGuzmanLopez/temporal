<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmmUsuarioAdopcion extends Model
{
    use HasFactory;

     //Tabla
   protected $table = "rmm_usuario_adopcion";

   //Timestamp
   public $timestamps = false;

   //Guarded
   protected $guarded = [];

   protected $fillable = [
      'usuario_cct_id',
      'adopcion_id',
      'estatus',
      'fechacreacion'
   ];
}
