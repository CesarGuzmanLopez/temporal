<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmmUsuarioRol extends Model
{


   use HasFactory;

    public $timestamps = false;
    protected $table="rmm_usuario_rol";
    protected $fillable = [
        
        'rol_id',
        'usuario_id'
    ];

   //Guarded
   protected $guarded = [];

   public function rol() { 

      return $this->belongsTo(CatRol::class, 'rol_id', 'id');
  }
  public function user() { 

      return $this->belongsTo(EntUsuario::class, 'usuario_id', 'id');
  }

}
