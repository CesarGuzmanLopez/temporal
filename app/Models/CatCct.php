<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatCct extends Model
{
    //Tabla
   protected $table = "vista_cct_nexus";

   //Timestamp
   public $timestamps = false;

   //Guarded
   protected $guarded = [];

}
