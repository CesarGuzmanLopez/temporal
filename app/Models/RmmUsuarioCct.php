<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmmUsuarioCct extends Model
{
    use HasFactory;

    //Tabla
   protected $table = "rmm_usuario_cct";

   //Timestamp
   public $timestamps = false;

   //Guarded
   protected $guarded = [];

   protected $fillable = [
      'usuario_id',
      'cct_id',
      'estatus',
      'fechacreacion',
      'publica_appcastillo',
      'publica_appmacmillan',
      'publica_marometadigital',
   ];

   public function ent_usuario(){
      return $this->belongsTo(EntUsuario::class, 'usuario_id','id');
   }

   public function cct() { 

      return $this->belongsTo(CatCct::class, 'cct_id','id');
  }
}
