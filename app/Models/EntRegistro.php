<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntRegistro extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table="ent_registro";
    protected $fillable = [
        
        'nombres',
        'apellidos',
        'correo',
        'contrasenia_plataforma',
        'pais_id',
        'telefonomovil',
        'path_photo'
    ];    

     public function user_cct(){
        return $this->belongsTo(RmmUsuarioCct::class, 'usuario_id','usuario_id');
    }
}
