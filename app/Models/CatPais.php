<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatPais extends Model
{
   //Tabla
   protected $table = "cat_pais";

   //Timestamp
   public $timestamps = false;

   //Guarded
   protected $guarded = [];


}
